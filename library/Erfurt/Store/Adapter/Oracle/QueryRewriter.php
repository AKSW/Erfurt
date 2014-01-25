<?php
use PHPSQL\Parser\Utils;

/**
 * Helper class that rewrites SPARQL queries to prepare them for execution by Oracle.
 *
 * Converts variable names to avoid clashes with reserved keyword and re-formats literals
 * to fit the format that is supported by Oracle (short literal in double quotes).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 25.01.14
 */
class Erfurt_Store_Adapter_Oracle_QueryRewriter
{

    /**
     * Prefix that is used for SPARQL variables to avoid
     * conflicts with keywords.
     */
    const VARIABLE_PREFIX = 'var_';

    /**
     * Rewrites the provided SPARQL query.
     *
     * @param string $query
     * @return string
     */
    public function rewrite($query)
    {
        $rewritten = '';
        $state     = new \SplStack();
        $state->push('in_query');
        $bytes  = str_split($query);
        $length = count($bytes);
        for ($i = 0; $i < $length; $i++) {
            /* @var $byte string */
            $byte = $bytes[$i];
            if ($state->top() === 'escape_character') {
                $state->pop();
                $rewritten .= $byte;
                continue;
            }
            switch ($byte) {
                case '?':
                case '$':
                    $rewritten .= $byte;
                    if ($state->top() === 'in_query') {
                        $variableName    = $this->getNameOfVariableAt($query, $i);
                        $newVariableName = $this->encodeVariableName($variableName);
                        $rewritten .= static::VARIABLE_PREFIX . $newVariableName;
                        $i += strlen($variableName);
                    }
                    break;
                case '<':
                    $rewritten .= $byte;
                    if ($state->top() === 'in_query') {
                        $state->push('in_iri');
                    }
                    break;
                case '>':
                    $rewritten .= $byte;
                    if ($state->top() === 'in_iri') {
                        $state->pop();
                    }
                    break;
                case '\'':
                case '"':
                    if ($state->top() === 'in_query') {
                        $literal    = $this->getLiteralAt($query, $i);
                        $rewritten .= $this->rewriteLiteral($literal);
                        $i += strlen($literal);
                    } else {
                        $rewritten .= $byte;
                    }
                    break;
                case '\\':
                    $state->push('escape_character');
                    $rewritten .= $byte;
                    break;
                default:
                    $rewritten .= $byte;
            }
        }
        return $rewritten;
    }

    /**
     * Rewrites the provided literal value.
     *
     * @param string $literalValue
     * @return string
     */
    protected function rewriteLiteral($literalValue)
    {
        // \Erfurt_Utils::buildLiteralString() escapes the enclosing quotes.
        // Therefore, we have to revert that step and encode the literal as expected by Oracle.
        $enclosingQuote          = $literalValue{0};
        $enclosingSequenceLength = 1;
        if (substr($literalValue, 0, 3) === str_repeat($enclosingQuote, 3)) {
            // This is a long literal.
            $enclosingSequenceLength = 3;
        }
        $rawValue = substr($literalValue, $enclosingSequenceLength, -$enclosingSequenceLength);
        $rawValue = str_replace('\\' . $enclosingQuote, $enclosingQuote, $rawValue);
        $rawValue = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::encodeLiteralValue($rawValue);
        return '"' . $rawValue . '"';
    }

    /**
     * Returns the literal that starts at position $index.
     *
     * The literal is returned with its enclosing quotes.
     *
     * @param string $query
     * @param integer $index
     * @return string
     */
    protected function getLiteralAt($query, $index)
    {
        $enclosingQuote    = $query{$index};
        $enclosingSequence = $enclosingQuote;
        if (isset($query{$index + 1}) && $query{$index + 1} === $enclosingQuote &&
            isset($query{$index + 2}) && $query{$index + 2} === $enclosingQuote) {
            // This is a long literal.
            $enclosingSequence .= $enclosingQuote . $enclosingQuote;
        }
        $start       = $index + strlen($enclosingSequence);
        $length      = strlen($query);
        $quotesInRow = 0;
        for ($i = $start; $i < $length; $i++) {
            if ($query{$i} === '\\') {
                // The next character is escaped so it is not required to check it.
                $i++;
                $quotesInRow = 0;
                continue;
            }
            if ($query{$i} !== $enclosingQuote) {
                // We are only interested in the enclosing quotes.
                $quotesInRow = 0;
                continue;
            }
            $quotesInRow++;
            if (strlen($enclosingSequence) === $quotesInRow) {
                // This is the end of the literal.
                return substr($query, $index, $i + 1 - $index);
            }
        }
        // The literal seems to be malformed. Simply return the rest of the query, which
        // will stop the rewriting.
        return substr($query, $index);
    }

    /**
     * Returns the name of the variable (without ? or $) that starts
     * in $query at position (byte-index) $index.
     *
     * @param string $query The SPARQL query.
     * @param integer $index The byte index of the ? or $ character.
     * @return string The name of the variable.
     */
    protected function getNameOfVariableAt($query, $index)
    {
        // Regular expression for variable names according to
        // <http://www.w3.org/TR/2013/REC-sparql11-query-20130321/#rVARNAME>
        $pnCharsBase = '[A-Z]|[a-z]|[\x{00C0}-\x{00D6}]|[\x{00D8}-\x{00F6}]|[\x{00F8}-\x{02FF}]'
                     . '|[\x{0370}-\x{037D}]|[\x{037F}-\x{1FFF}]|[\x{200C}-\x{200D}]|[\x{2070}-\x{218F}]'
                     . '|[\x{2C00}-\x{2FEF}]|[\x{3001}-\x{D7FF}]|[\x{F900}-\x{FDCF}]|[\x{FDF0}-\x{FFFD}]'
                     . '|[\x{10000}-\x{EFFFF}]';
        $pnCharsU = $pnCharsBase . '|[_]';
        $varName  = '(' . $pnCharsU . '|[0-9])' // First character.
                  . '(' . $pnCharsU . '|[0-9]|[\x{00B7}]|[\x{0300}-\x{036F}]|[\x{203F}-\x{2040}]})*';
        $matches = array();
        preg_match('/' . $varName . '/u', $query, $matches, 0, $index + 1);
        return $matches[0];
    }

    /**
     * Encodes the provided variable name to be able to restore upper/lower case characters
     * in the results.
     *
     * @param string $variable
     * @return string
     */
    protected function encodeVariableName($variable)
    {
        return \Erfurt_Store_Adapter_Oracle_ResultConverter_Util::encodeVariableName($variable);
    }

}

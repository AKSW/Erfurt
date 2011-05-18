<?php
/**
 * Represents a constraint. A value constraint is a boolean- valued expression
 * of variables and RDF Terms.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: Constraint.php 3021 2009-05-04 13:45:43Z pfrischmuth $
 */
class Erfurt_Sparql_Constraint 
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The expression string.
     * 
     * @var string
     */
    protected $expression;

    /**
     * True if it is an outer filter, false if not.
     * 
     * @var boolean
     */
    protected $outer;

    /**
     * The expression tree
     *
     * @var array
     */
    protected $tree = null;
    
    /**
     * Contains all variables that are used in the constraint expression (recursivly).
     * This array is calculated once, if the tree is set in order to avoid multiple calculation.^
     *
     * @var array
     */
    protected $_usedVars = null;
    
    protected $_tokens = null;

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Adds an expression string.
     *
     * @param  String $exp the expression String
     * @return void
     */
    public function addExpression($exp)
    {
        $this->expression = $exp;
    }

    /**
     * Returns the expression string.
     *
     * @return String  the expression String
     */
    public function getExpression()
    {
        return $this->expression;
    }
    
    public function getTree()
    {
        return $this->tree;
    }

    public function getUsedVars()
    {
        if (null === $this->_usedVars) {
            $this->_usedVars = array_unique($this->_resolveUsedVarsRecursive($this->tree));
        }
        
        return $this->_usedVars;
    }
    
    /**
     * Returns true if this constraint is an outer filter- false if not.
     *
     * @return boolean
     */
    public function isOuterFilter()
    {
        return $this->outer;
    }

    /**
     * Sets the filter type to outer or inner filter.
     * True for outer false for inner.
     *
     * @param  boolean $boolean
     * @return void
     */
    public function setOuterFilter($boolean)
    {
        $this->outer = $boolean;
    }

    public function setTree($tree)
    {
        $this->tree = $tree;
        
        // If the tree is set or reset, the used variables need to be resolved again.
        $this->_usedVars = null;
    }
    
    public function parse()
    {
        $this->_tokens = Erfurt_Sparql_Parser::tokenize($this->expression);
        
        $this->setOuterFilter(true);
        $this->setTree($this->_parseConstraintTree());
        
        $this->_tokens = null;
    }
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------    
    
    protected function _resolveUsedVarsRecursive($tree) 
    {
        $usedVars = array();
            
        if ($tree['type'] === 'function') {
            foreach ($tree['parameter'] as $paramArray) {
                if ($paramArray['type'] === 'value') {
                    if (is_string($paramArray['value']) && 
                            ($paramArray['value'][0] === '?' || $paramArray['value'][0] === '$')) {
                        
                        $usedVars[] = $paramArray['value'];
                    }
                } else if ($paramArray['type'] === 'function') {
                    foreach ($paramArray['parameter'] as $p) {
                        if (is_string($p['value']) &&
                                ($p['value'][0] === '?' || $p['value'][0] === '$')) {
                            
                            $usedVars[] = $p['value'];
                        }
                    }
                } 
            }
        } else if ($tree['type'] === 'value') {
            if ($tree['value'][0] === '?' || $tree['value'][0] === '$') {
                $usedVars[] = $tree['value'];
            }
        } else {
            $usedVars = array_merge($usedVars, $this->_resolveUsedVarsRecursive($tree['operand1']));
            $usedVars = array_merge($usedVars, $this->_resolveUsedVarsRecursive($tree['operand2']));    
        }
        
        return $usedVars;
    }
    
    protected function _parseConstraintTree($nLevel = 0, $bParameter = false)
    {
        $tree       = array();
        $part       = array();
        $chQuotes   = null;
        $litQuotes  = null;
        $strQuoted  = '';
        $parens     = false;

        while ($tok = next($this->_tokens)) {
            if ($chQuotes !== null && $tok != $chQuotes) {
                $strQuoted .= $tok;
                continue;
            } else if ($litQuotes !== null) {
                $strQuoted .= $tok;
                if ($tok[strlen($tok) - 1] === '>') {
                    $tok = '>';
                } else {
                    continue;
                }
            } else if ($tok === ')' || $tok === '}' || $tok === '.') {
                break;
            } else if (strtolower($tok) === 'filter' || strtolower($tok) === 'optional') {
                break;
            }

            switch ($tok) {
                case '"':
                case '\'':
                    if ($chQuotes === null) {
                        $chQuotes  = $tok;
                        $strQuoted = '';
                    } else {
                        $chQuotes = null;
                        $part[] = array(
                            'type'  => 'value',
                            'value' => $strQuoted,
                            'quoted'=> true
                        );
                    }
                    continue 2;
                    break;
                case '>':
                    $litQuotes = null;
                    $part[] = array(
                        'type'  => 'value',
                        'value' => $strQuoted,
                        'quoted'=> false
                    );
                    continue 2;
                    break;
                case '(':
                    $parens = true;
                    $bFunc1 = isset($part[0]['type']) && $part[0]['type'] === 'value';
                    $bFunc2 = isset($tree['type']) && $tree['type'] === 'equation'
                           && isset($tree['operand2']) && isset($tree['operand2']['value']);
                    $part[] = $this->_parseConstraintTree(
                        $nLevel + 1,
                        $bFunc1 || $bFunc2
                    );
                    
                    if ($bFunc1) {
                        $tree['type'] = 'function';
                        $tree['name'] = $part[0]['value'];
                        Erfurt_Sparql_Parser::fixNegationInFuncName($tree);
                        if (isset($part[1]['type'])) {
                            $part[1] = array($part[1]);
                        }
                        $tree['parameter'] = $part[1];
                        $part = array();
                    } else if ($bFunc2) {
                        $tree['operand2']['type'] = 'function';
                        $tree['operand2']['name'] = $tree['operand2']['value'];
                        Erfurt_Sparql_Parser::fixNegationInFuncName($tree['operand2']);
                        $tree['operand2']['parameter']  = $part[0];
                        unset($tree['operand2']['value']);
                        unset($tree['operand2']['quoted']);
                        $part = array();
                    }
                    
                    if (current($this->_tokens) === ')') {
                        if (substr(next($this->_tokens), 0, 2) === '_:') {
                            // filter ends here
                            prev($this->_tokens);
                            break 2;
                        } else {
                            prev($this->_tokens);
                        }
                    }
                    
                    continue 2;
                    break;
                case ' ':
                case "\t":
                    continue 2;
                case '=':
                case '>':
                case '<':
                case '<=':
                case '>=':
                case '!=':
                case '&&':
                case '||':
                    if (isset($tree['type']) && $tree['type'] === 'equation' && isset($tree['operand2'])) {
                        //previous equation open
                        $part = array($tree);
                    } else if (isset($tree['type']) && $tree['type'] !== 'equation') {
                        $part = array($tree);
                        $tree = array();
                    }
                    
                    $tree['type'] = 'equation';
                    $tree['level'] = $nLevel;
                    $tree['operator'] = $tok;
                    $tree['operand1'] = $part[0];
                    unset($tree['operand2']);
                    $part = array();
                    continue 2;
                    break;
                case '!':
                    if ($tree != array()) {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException(
                            'Unexpected "!" negation in constraint.', -1, current($this->_tokens));
                    }
                    $tree['negated'] = true;
                    continue 2;
                case ',':
                    //parameter separator
                    if (count($part) == 0 && !isset($tree['type'])) {
                        throw new SparqlParserException(
                            'Unexpected comma'
                        );
                    }
                    $bParameter = true;
                    if (count($part) === 0) {
                        $part[] = $tree;
                        $tree = array();
                    }
                    continue 2;
                default:
                    break;
            }

            if ($this->_varCheck($tok)) {
                if (!$parens && $nLevel === 0) {
                    // Variables need parenthesizes first
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException('FILTER expressions that start with a variable need parenthesizes.', -1, current($this->_tokens));
                }
                
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false
                );
            } else if (substr($tok, 0, 2) === '_:') {
                // syntactic blank nodes not allowed in filter
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Syntactic Blanknodes not allowed in FILTER.', -1,
                                current($this->_tokens));
            } else if (substr($tok, 0, 2) === '^^') {
                $part[count($part) - 1]['datatype'] = $this->_query->getFullUri(substr($tok, 2));
            } else if ($tok[0] === '@') {
                $part[count($part) - 1]['language'] = substr($tok, 1);
            } else if ($tok[0] === '<') {
                if ($tok[strlen($tok) - 1] === '>') {
                    //single-tokenized <> uris
                    $part[] = array(
                        'type'      => 'value',
                        'value'     => $tok,
                        'quoted'    => false
                    );
                } else {
                    //iris split over several tokens
                    $strQuoted = $tok;
                    $litQuotes = true;
                }
            } else if ($tok === 'true' || $tok === 'false') {
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false,
                    'datatype'  => 'http://www.w3.org/2001/XMLSchema#boolean'
                );
            } else {
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false
                );
            }

            if (isset($tree['type']) && $tree['type'] === 'equation' && isset($part[0])) {
                $tree['operand2'] = $part[0];
                Erfurt_Sparql_Parser::balanceTree($tree);
                $part = array();
            }
        }
        
        if (!isset($tree['type']) && $bParameter) {
            return $part;
        } else if (isset($tree['type']) && $tree['type'] === 'equation'
            && isset($tree['operand1']) && !isset($tree['operand2'])
            && isset($part[0])) {
            $tree['operand2'] = $part[0];
            Erfurt_Sparql_Parser::balanceTree($tree);
        }

        if ((count($tree) === 0) && (count($part) > 1)) {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Failed to parse constraint.', -1, current($this->_tokens));
        }
        
        if (!isset($tree['type']) && isset($part[0])) {
            if (isset($tree['negated'])) {
                $part[0]['negated'] = true;
            }
            return $part[0];
        }

        return $tree;
    }
    
    protected function _varCheck($token)
    {
        if (isset($token[0]) && ($token{0} == '$' || $token{0} == '?')) {
            return true;
        }
        
        return false;
    }
}

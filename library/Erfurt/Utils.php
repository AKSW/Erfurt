<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * OntoWiki utility class.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package
 * @author Natanael Arndt <arndtn@gmail.com>
 * @author Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Utils
{
    public static function isXmlPrefix ($string)
    {
        /*
         * The folowing regularexpression would match all allowed prefixes,
         * but couses trouble with PCRE.
         * /[A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\x2FF\x370-\x37D\x37F-\x1FFF
         * \x200C-\x200D\x2070-\x218F\x2C00-\x2FEF\x3001-\xD7FF\xF900-\xFDCF
         * \xFDF0-\xFFFD\x10000-\xEFFFF]{1}[-A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\x2FF
         * \x370-\x37D\x37F-\x1FFF\x200C-\x200D\x2070-\x218F\x2C00-\x2FEF
         * \x3001-\xD7FF\xF900-\xFDCF\xFDF0-\xFFFD.0-9\xB7\x0300-\x036F
         * \x203F-\x2040\x10000-\xEFFFF]*\/u
         * @see {http://www.w3.org/TR/REC-xml/#NT-Letter}
         * @see {http://www.w3.org/TR/REC-xml/#NT-NameChar}
         * the first part of this regexp is incorrect
         */
        $matches = array();
        $regExp = '/[A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\xFF]{1}'
                . '[-A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\xFF.0-9\xB7]*/u';

        $matchCount = preg_match($regExp, $string, $matches);
        if ($matchCount > 0 && $matches[0] === $string) {
            return true;
        }

        return false;
    }

    /**
     * Build a Turtle-compatible literal string out of an RDF/PHP array object.
     * This string is used as the canonical representation for object values in Erfurt.
     * @see {http://www.w3.org/TR/turtle/ RDF 1.1 Turtle}
     * @param mixed $value the literal values
     * @param string|null $datatype optionally the datatype of the literal
     * @param string|null $lang optionally the language tag of the literal
     * @param boolean $longStringEnabled decides if the output can be a long string (""" """) or not
     * @return string the turtle literal representation
     */
    public static function buildLiteralString($value, $datatype = null, $lang = null, $longStringEnabled = true)
    {
        $longString = false;
        $quoteChar  = (strpos($value, '"') !== false) ? "'" : '"';
        $value      = (string)$value;

        // datatype-specific treatment
        switch ($datatype) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                if ($value == 'true' || $value == 'false') {
                    break;
                } else if (is_string($value) && strpos($value, '0') !== false) {
                    // replace all 0 by nothing, because empty string will evaluate to false
                    $value = strtr($value, '0', '');
                }
                $value = ($value ? 'true' : 'false');
                break;
            case 'http://www.w3.org/2001/XMLSchema#decimal':
            case 'http://www.w3.org/2001/XMLSchema#integer':
            case 'http://www.w3.org/2001/XMLSchema#int':
            case 'http://www.w3.org/2001/XMLSchema#float':
            case 'http://www.w3.org/2001/XMLSchema#double':
            case 'http://www.w3.org/2001/XMLSchema#duration':
            case 'http://www.w3.org/2001/XMLSchema#dateTime':
            case 'http://www.w3.org/2001/XMLSchema#date':
            case 'http://www.w3.org/2001/XMLSchema#gYearMonth':
            case 'http://www.w3.org/2001/XMLSchema#gYear':
            case 'http://www.w3.org/2001/XMLSchema#gMonthDay':
            case 'http://www.w3.org/2001/XMLSchema#gDay':
            case 'http://www.w3.org/2001/XMLSchema#gMonth':
            case 'http://www.w3.org/2001/XMLSchema#anyURI':
            case 'http://www.w3.org/2001/XMLSchema#time':
                /* no normalization needed for these types */
                break;
            case '':    /* fallthrough */
            case null:  /* fallthrough */
            case 'http://www.w3.org/1999/02/22-rdf-syntax-ns#XMLLiteral':   /* fallthrough */
            case 'http://www.w3.org/2001/XMLSchema#string':
            default:
                $replaceCharlist = $quoteChar . "\\";

                /**
                 * Check for characters not allowed in a short literal
                 * {@link http://www.w3.org/TR/rdf-sparql-query/#rECHAR}
                 */
                if ($longStringEnabled && $pos = preg_match('/[\r\n]/', $value)) {
                    $longString = true;
                    $value = self::decodeTurtleString($value);
                } else {
                    /*
                     * Replaces the characters traditionally escaped in string literals by the
                     * corresponding escape sequences
                     */
                    $replaceCharlist .= "\n\t\r\f";
                    $value = addcslashes($value, $replaceCharlist);
                }
        }

        // add short, long literal quotes respectively
        $value = $quoteChar . ($longString ? ($quoteChar . $quoteChar) : '')
               . $value
               . $quoteChar . ($longString ? ($quoteChar . $quoteChar) : '');

        // add datatype URI/lang tag
        if (!empty($datatype)) {
            $value .= '^^<' . (string)$datatype . '>';
        } else if (!empty($lang)) {
            $value .= '@' . (string)$lang;
        }

        return $value;
    }

    /**
     * Decodes a Turtle literal string containing Unicode code points as UTF-8.
     * @see {http://stackoverflow.com/questions/1805802/php-convert-unicode-codepoint-to-utf-8}
     *
     * @param string $cpString
     * @return string
     */
    private static function decodeTurtleString($cpString)
    {
        // TODO: implement Unicode codepoint decoding
        //$entityString = preg_replace('/\\\[uU]\+([0-9A-F]{3,5})/', '&#\\1;', $cpString);
        //$utf8String   = html_entity_decode($entityString);

        return $cpString;
    }
}

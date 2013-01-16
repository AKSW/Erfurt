<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * OntoWiki utility class.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @packaget
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
     * @see {http://www.w3.org/TeamSubmission/turtle/}
     * @param array literal object
     * @return string
     */
    public static function buildLiteralString($value, $datatype = null, $lang = null)
    {
        $longString = false;
        $quoteChar  = (strpos($value, '"') !== false) ? "'" : '"';
        $value      = (string)$value;

        // datatype-specific treatment
        switch ($datatype) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                $search  = array('0', '1');
                $replace = array('false', 'true');
                $value   = str_replace($search, $replace, $value);
                break;
            case 'http://www.w3.org/2001/XMLSchema#decimal':
            case 'http://www.w3.org/2001/XMLSchema#integer':
            case 'http://www.w3.org/2001/XMLSchema#int':
            case 'http://www.w3.org/2001/XMLSchema#float':
            case 'http://www.w3.org/2001/XMLSchema#double':
            case 'http://www.w3.org/2001/XMLSchema#duration':
            case 'http://www.w3.org/2001/XMLSchema#dateTime':
            case 'http://www.w3.org/2001/XMLSchema#date':
            case 'http://www.w3.org/2001/XMLSchema#gMonthDay':
            case 'http://www.w3.org/2001/XMLSchema#anyURI':
            case 'http://www.w3.org/2001/XMLSchema#time':
                /* no normalization needed for these types */
                break;
            case '':    /* fallthrough */
            case null:  /* fallthrough */
            case 'http://www.w3.org/1999/02/22-rdf-syntax-ns#XMLLiteral':   /* fallthrough */
            case 'http://www.w3.org/2001/XMLSchema#string':
            default:
                $value = addcslashes($value, $quoteChar);

                /**
                 * Check for characters not allowed in a short literal
                 * {@link http://www.w3.org/TR/rdf-sparql-query/#rECHAR}
                 */
                if ($pos = preg_match('/[\x5c\r\n"]/', $value)) {
                    $longString = true;
                    $value = self::decodeTurtleString($value);
                    // $value = trim($value, "\n\r");
                    // $value = str_replace("\x0A", '\n', $value);
                }
                break;
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
    public static function decodeTurtleString($cpString)
    {
        // TODO: implement Unicode codepoint decoding
        //$entityString = preg_replace('/\\\[uU]\+([0-9A-F]{3,5})/', '&#\\1;', $cpString);
        //$utf8String   = html_entity_decode($entityString);

        return $cpString;
    }

    /**
     * This method fetches a property via Linked Data and tries to determine the inverse of it.
     * TODO: Use LinkedData Wrapper
     *
     * @param $propertyUri the uri of the property whose inverse should be found
     * @return string|null with the inverse property or null if nothing was found
     */
    public static function determineInverseProperty ($propertyUri)
    {
        $client = Erfurt_App::getInstance()->getHttpClient(
            $propertyUri,
            array(
                'maxredirects' => 10,
                'timeout' => 30
            )
        );

        $client->setHeaders('Accept', 'application/rdf+xml');

        try {
            $response = $client->request();
        } catch (Exception $e) {
            return null;
        }

        if ($response->getStatus() === 200) {
            $data = $response->getBody();

            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('rdfxml');

            try {
                $result = $parser->parse($data, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
            } catch (Exception $e) {
                return null;
            }

            if (isset($result[$propertyUri])) {
                $pArray = $result[$propertyUri];

                if (isset($pArray['http://www.w3.org/2002/07/owl#inverseOf'])) {
                    $oArray = $pArray['http://www.w3.org/2002/07/owl#inverseOf'];
                    return $oArray[0]['value'];
                }
            }

            return null;
        }
    }
}

<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Converts a SPARQL results JSON to an PHP array.
 *
 * The array structure conforms to what would be yielded by 
 * applying json_decode to a JSON-encoded SPARQL result set
 * ({@link http://www.w3.org/TR/rdf-sparql-json-res/}).
 *
 * @category Erfurt
 * @package Store_Adapter_Virtuoso_ResultConverter
 * @author Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Virtuoso_ResultConverter_Json
{
    // ------------------------------------------------------------------------
    // --- Public Methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Converts a JSON result string to an RDF/PHP array.
     *
     * @param string $jsonSparqlResults The JSON SPARQL result string
     * @return array
     */
    public function convert($jsonSparqlResults)
    {
        $result = json_decode($jsonSparqlResults, true);
        return $result;
    }
}


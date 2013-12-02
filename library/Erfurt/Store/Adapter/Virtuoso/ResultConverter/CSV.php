<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Converts a SPARQL results PHP array to an CSV string.
 *
 * @category Erfurt
 * @package Erfurt_Store_Adapter_Virtuoso_ResultConverter
 * @author Andreas Nareike <nareike@information.uni-leipzig.de>
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Virtuoso_ResultConverter_CSV
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
    public function convert($resultsArray)
    {
        $csv = array($this->_convertArrayRowToCSV(array_keys($resultsArray[0])));
        foreach($resultsArray as $row)
        {
            $csv[] = $this->_convertArrayRowToCSV($row);
        }
        /**
         * Note: '\r\n' is actually what should be used in CSV files,
         * see also http://www.w3.org/TR/sparql11-results-csv-tsv/
         */
        $result = implode("\r\n", $csv) . "\r\n";
        return $result;
    }

    /**
     * Converts a single array into a CSV line. This is usually used with
     * files and there does not seem to be an analogous function which
     * does this with string. So we improvise with a buffer.
     *
     * @param array of strings
     * @return string
     */
    private function _convertArrayRowToCSV($row)
    {
        ob_start();
        $csv = fopen('php://output', 'w');
        fputcsv($csv, $row);
        fclose($csv);
        // remove new line, since we will add our own
        return rtrim(ob_get_clean());
    }
}


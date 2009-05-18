<?php
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer/Extended.php';

/**
 * Result renderer that creates a JSON object string containing the result of a SPARQL query as defined in
 * @link http://www.w3.org/TR/rdf-sparql-json-res/.
 *
 * @subpackage sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version	$Id: $
 */
class Erfurt_Sparql_EngineDb_ResultRenderer_Json extends Erfurt_Sparql_EngineDb_ResultRenderer_Extended 
{
    /**
     * Converts the database results into the desired output format
     * and returns the result.
     *
     * @param array $arRecordSets Array of (possibly several) SQL query results.
     * @param Erfurt_Sparql_Query $query SPARQL query object
     * @param $engine Sparql Engine to query the database
     * @return array
     */
    public function convertFromDbResults($arRecordSets, Erfurt_Sparql_Query $query, $engine, $vars)
    {
        $result = parent::convertFromDbResults($arRecordSets, $query, $engine, $vars);
        return json_encode($result);        
    }
}

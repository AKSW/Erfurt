<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Result renderer that creates a JSON object string containing the result of a SPARQL query as defined in
 * @link http://www.w3.org/TR/rdf-sparql-json-res/.
 *
 * @package Erfurt_Sparql_EngineDb_ResultRenderer
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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

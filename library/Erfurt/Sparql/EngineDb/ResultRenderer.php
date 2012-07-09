<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Result renderer interface that any result renderer needs to implement.
 * A result renderer converts the raw database results into a
 * - for the user - usable result format, e.g. php arrays, xml, json and
 * so on.
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @package Erfurt_Sparql_EngineDb
 */
interface Erfurt_Sparql_EngineDb_ResultRenderer
{
    /**
     *   Converts the database results into the desired output format
     *   and returns the result.
     *
     *   @param array $arRecordSets  Array of (possibly several) SQL query results.
     *   @param Query $query     SPARQL query object
     *   @param SparqlEngineDb $engine   Sparql Engine to query the database
     *   @return mixed   The result as rendered by the result renderers.
     */
    public function convertFromDbResults($arRecordSets, Erfurt_Sparql_Query $query, $engine, $vars);
}

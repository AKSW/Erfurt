<?php

/**
 * Erfurt SQL interface
 *
 * @package    versioning
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

interface Erfurt_Store_Sql_Interface
{
    
    /**
     * Creates the table specified by $tableSpec according to backend-specific 
     * create table statement.
     *
     * @param array $tableSpec An associative array of SQL column names and columnd specs.
     */
    public function createTable(array $tableSpec);
    
    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     *
     * @return array
     */
    public function sqlQuery($sqlQuery);
}



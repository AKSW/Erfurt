<?php

/**
 * Erfurt SQL interface
 *
 * @package    store
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
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
     * @param string $tableName
     * @param array $tableSpec An associative array of SQL column names and columnd specs.
     */
    public function createTable($tableName, array $columns);
    
    /**
     * Returns the ID for the last insert statement.
     */
    public function lastInsertId();
    
    /**
     * Returns an array containing all tables existing in the database.
     * 
     * @return array
     */
    public function listTables();
    
    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     *
     * @return array
     */
    public function sqlQuery($sqlQuery);
}



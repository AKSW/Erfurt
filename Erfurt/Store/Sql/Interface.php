<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt SQL interface
 *
 * @category Erfurt
 * @package Store_Sql
 * @author Norman Heino <norman.heino@gmail.com>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
     *
     * @return int
     */
    public function lastInsertId();
    
    /**
     * Returns an array of SQL tables available in the store.
     *
     * @param string $prefix An optional table prefix to filter table names.
     * @return array
     */
    public function listTables($prefix = '');
    
    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     * @param int $limit Maximum number of results to return
     * @param int $offset The number of results to skip from the beginning
     * @return array
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0);
}



<?php

use Doctrine\DBAL\Connection;

/**
 * Access layer for the basic Oracle SQL functionality.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 */
class Erfurt_Store_Adapter_Oracle_OracleSqlAdapter implements Erfurt_Store_Sql_Interface
{

    /**
     * Creates an adapter that uses the provided database connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {

    }

    /**
     * Creates the table specified by $tableSpec according to backend-specific
     * create table statement.
     *
     * @param string $tableName
     * @param array $columns An associative array of SQL column names and column specs.
     */
    public function createTable($tableName, array $columns)
    {
        // TODO: Implement createTable() method.
    }

    /**
     * Returns the ID for the last insert statement.
     *
     * @return int
     */
    public function lastInsertId()
    {
        // TODO: Implement lastInsertId() method.
    }

    /**
     * Returns an array of SQL tables available in the store.
     *
     * @param string $prefix An optional table prefix to filter table names.
     * @return array
     */
    public function listTables($prefix = '')
    {
        // TODO: Implement listTables() method.
    }

    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     * @param int $limit Maximum number of results to return
     * @param int $offset The number of results to skip from the beginning
     * @return array
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        // TODO: Implement sqlQuery() method.
    }

}

<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

/**
 * Access layer for the basic Oracle SQL functionality.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 */
class Erfurt_Store_Adapter_Oracle_OracleSqlAdapter implements Erfurt_Store_Sql_Interface
{

    /**
     * The connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Creates an adapter that uses the provided database connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
        $table = new Table($tableName);
        foreach ($columns as $name => $specification) {
            /* @var $name string */
            /* @var $specification string */
            if (strpos($specification, 'INT') !== false) {
                $type = Type::INTEGER;
            } else if (strpos($specification, 'TEXT') !== false) {
                $type = Type::TEXT;
            } else {
                $type = Type::STRING;
            }
            $options = array();
            if (strpos($specification, 'DEFAULT NULL') !== false) {
                $options['default'] = null;
            } else if (strpos($specification, 'NOT NULL') !== false) {
                $options['notnull'] = true;
            }
            if (strpos($specification, 'AUTO_INCREMENT')) {
                // TODO sequence?
            }
            $table->addColumn($name, $type, $options);
        }
        $this->connection->getSchemaManager()->dropAndCreateTable($table);
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
        $names = $this->connection->getSchemaManager()->listTableNames();
        $names = array_map('strtolower', $names);
        if ($prefix !== '') {
            $names = array_filter($names, function ($name) use ($prefix) {
                return strpos($name, $prefix) === 0;
            });
        }
        return $names;
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
        $this->connection->exec($sqlQuery);
    }

}

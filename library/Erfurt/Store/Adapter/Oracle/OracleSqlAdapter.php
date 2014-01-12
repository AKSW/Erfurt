<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;
use PHPSQL\Creator;
use PHPSQL\Parser;

/**
 * Access layer for the basic Oracle SQL functionality.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 */
class Erfurt_Store_Adapter_Oracle_OracleSqlAdapter implements Erfurt_Store_Sql_Interface
{

    /**
     * The name of the sequence that is used for ID generation.
     */
    const ID_GENERATOR_SEQUENCE_NAME = 'ERFURT_ID_GENERATOR';

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
        $tableName = strtoupper($tableName);
        $table     = new Table($tableName);
        $autoIncrementColumns = array();
        $primaryKeyColumns    = array();
        foreach ($columns as $name => $specification) {
            /* @var $name string */
            /* @var $specification string */
            // Always use the upper case as column name, otherwise column names
            // might not match in SQL queries as Oracle interprets all identifiers
            // as uppercase (if not quoted).
            $name = strtoupper($name);
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
                $autoIncrementColumns[] = $name;
            }
            if (strpos($specification, 'PRIMARY KEY') !== false) {
                $primaryKeyColumns[] = $name;
            }
            $table->addColumn($name, $type, $options);
        }
        if (count($primaryKeyColumns) > 0) {
            $table->setPrimaryKey($primaryKeyColumns);
        }
        $this->connection->getSchemaManager()->dropAndCreateTable($table);
        foreach ($autoIncrementColumns as $name) {
            /* @var $name string */
            $this->connectWithIdGenerator($tableName, $name);
        }
    }

    /**
     * Returns the ID for the last insert statement.
     *
     * @return int
     */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId(static::ID_GENERATOR_SEQUENCE_NAME);
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
        $sqlQuery = $this->rewriteSelect($sqlQuery);
        if (!$this->isSelect($sqlQuery)) {
            $this->connection->exec($sqlQuery);
            return array();
        }
        if ($limit !== PHP_INT_MAX || $offset > 0) {
            $sqlQuery = $this->connection->getDatabasePlatform()->modifyLimitQuery($sqlQuery, $limit, $offset);
        }
        $rows = $this->connection->query($sqlQuery)->fetchAll();
        return array_map(function (array $row) {
            return array_change_key_case($row, CASE_LOWER);
        }, $rows);
    }

    /**
     * Rewrites the provided SELECT query to remove MySQL specific parts
     * and apply proper escaping.
     *
     * @param string $query
     * @return string
     */
    protected function rewriteSelect($query)
    {
        $parser = new Parser();
        $parsed = $parser->parse($query);
        if (isset($parsed['INSERT'])) {
            // Assign the first INSERT entry. Otherwise the creator seems to fail
            // when creating the statement.
            $parsed['INSERT'] = current($parsed['INSERT']);
            if (isset($parsed['INSERT']['columns']) && is_array($parsed['INSERT']['columns'])) {
                $parsed['INSERT']['columns'] = $this->quoteIdentifiers($parsed['INSERT']['columns']);
            }
        }
        foreach (array('SELECT', 'FROM', 'WHERE') as $partName) {
            /* @var $partName string */
            if (!isset($parsed[$partName])) {
                continue;
            }
            $parsed[$partName] = $this->quoteIdentifiers($parsed[$partName]);
        }
        $creator = new Creator();
        $rewritten = $creator->create($parsed);
        return $rewritten;
    }

    /**
     * Quotes the identifiers that occur in the provided query parts.
     *
     * @param array(array(string=>mixed)) $parts
     * @return array(array(string=>mixed))
     */
    protected function quoteIdentifiers(array $parts)
    {
        foreach (array_keys($parts) as $index) {
            /* @var $index integer */
            if ($parts[$index]['expr_type'] === 'colref' && $parts[$index]['base_expr'] !== '*') {
                $parts[$index]['base_expr'] = $this->quoteIdentifier($parts[$index]['base_expr']);
            } else if ($parts[$index]['expr_type'] === 'table') {
                $parts[$index]['table'] = $this->quoteIdentifier($parts[$index]['table']);
            }
            if (isset($parts[$index]['alias']) && $parts[$index]['alias'] !== false) {
                $parts[$index]['alias']['as'] = false;
                $parts[$index]['alias']['name'] = $this->quoteIdentifier($parts[$index]['alias']['name']);
            }
        }
        return $parts;
    }

    /**
     * Quotes the provided identifier.
     *
     * @param string $identifier
     * @return string
     */
    protected function quoteIdentifier($identifier)
    {
        return $this->connection->quoteIdentifier(strtoupper($identifier));
    }

    /**
     * Checks if $query is a SELECT query.
     *
     * @param string $query
     * @return boolean
     */
    protected function isSelect($query)
    {
        return strpos(ltrim($query), 'SELECT ') === 0;
    }

    /**
     * Connects the provided column with the ID generation system.
     *
     * @param string $table
     * @param string $column
     */
    protected function connectWithIdGenerator($table, $column)
    {
        $sequence    = $this->getIdGeneratorSequence();
        $triggerName = $table . '_' . $column . '_AI';
        $sql = 'CREATE TRIGGER ' . $triggerName . '
                   BEFORE INSERT
                   ON ' . $table . '
                   FOR EACH ROW
                DECLARE
                   last_Sequence NUMBER;
                   last_InsertID NUMBER;
                BEGIN
                   SELECT ' . $sequence->getName() . '.NEXTVAL INTO :NEW.' . $column . ' FROM DUAL;
                   IF (:NEW.' . $column . ' IS NULL OR :NEW.' . $column . ' = 0) THEN
                      SELECT ' . $sequence->getName() . '.NEXTVAL INTO :NEW.' . $column . ' FROM DUAL;
                   ELSE
                      SELECT NVL(Last_Number, 0) INTO last_Sequence
                        FROM User_Sequences
                       WHERE Sequence_Name = \'' . $sequence->getName() . '\';
                      SELECT :NEW.' . $column . ' INTO last_InsertID FROM DUAL;
                      WHILE (last_InsertID > last_Sequence) LOOP
                         SELECT ' . $sequence->getName() . '.NEXTVAL INTO last_Sequence FROM DUAL;
                      END LOOP;
                   END IF;
                END;';
        $this->connection->exec($sql);
    }

    /**
     * Creates a sequence that is used for ID generation.
     *
     * @return Sequence
     */
    protected function getIdGeneratorSequence()
    {
        $sequences = $this->connection->getSchemaManager()->listSequences();
        foreach ($sequences as $sequence) {
            /* @var $sequence \Doctrine\DBAL\Schema\Sequence */
            if ($sequence->getName() === static::ID_GENERATOR_SEQUENCE_NAME) {
                return $sequence;
            }
        }
        // Sequence does not exist yet, we have to create it.
        $sequence = new Sequence(static::ID_GENERATOR_SEQUENCE_NAME);
        $this->connection->getSchemaManager()->createSequence($sequence);
        return $sequence;
    }

}

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
            } else if (strpos($specification, 'TEXT') !== false || strpos($specification, 'LONG') !== false) {
                $type = Type::TEXT;
            } else if (strpos($specification, 'FLOAT') !== false) {
                $type = Type::FLOAT;
            } else {
                $type = Type::STRING;
            }
            $options = array('notnull' => false);
            if (strpos($specification, 'DEFAULT NULL') !== false) {
                $options['default'] = null;
            } else if (strpos($specification, 'NOT NULL') !== false) {
                $options['notnull'] = true;
            }
            if (strpos($specification, 'AUTO_INCREMENT')) {
                $autoIncrementColumns[] = $name;
            }
            if (strpos($specification, 'PRIMARY KEY') !== false) {
                $matches = array();
                preg_match('/PRIMARY KEY \(([a-zA-Z ,]+)\)/', $specification, $matches);
                if (isset($matches[1])) {
                    // Multiple columns are specified as primary key here...
                    $names = explode(', ', $matches[1]);
                    $names = array_map('trim', $names);
                    $primaryKeyColumns = array_merge($primaryKeyColumns, $names);
                } else {
                    $primaryKeyColumns[] = $name;
                }
            }
            $matches = array();
            if (preg_match('/VARCHAR\((\d+)\)/', $specification, $matches)) {
                $options['length'] = (int)$matches[1];
            }
            $table->addColumn($name, $type, $options);
        }
        $primaryKeyColumns = array_unique($primaryKeyColumns);
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
     * @throws Erfurt_Store_Adapter_Exception If an error occurs.
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        try {
            $converted = $this->rewriteQuery($sqlQuery);
            if (!$this->isSelectQuery($sqlQuery)) {
                $statement = $this->connection->prepare($converted->query);
                $statement->execute($converted->params);
                return array();
            }
            if ($limit !== PHP_INT_MAX || $offset > 0) {
                $platform = $this->connection->getDatabasePlatform();
                $converted->query = $platform->modifyLimitQuery(
                    $converted->query,
                    $limit,
                    $offset
                );
            }
            $statement = $this->connection->prepare($converted->query);
            $statement->execute($converted->params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return array_map(function (array $row) {
                return array_change_key_case($row, CASE_LOWER);
            }, $rows);
        } catch (Exception $e) {
            // Normalize the exception type.
            throw new Erfurt_Store_Adapter_Exception($e->getMessage(), 0, $e);
        }
    }

    /**
     * Rewrites the provided query to remove MySQL specific parts
     * and apply proper escaping.
     *
     * Returns an object that contains the query as well as associated
     * parameters.
     * The object has the following attributes:
     *
     * * query  - The rewritten query as string.
     * * params - A map from parameter names to parameter values.
     *
     * @param string $query
     * @param string $prefix A prefix for parameter names.
     * @return \stdClass
     */
    protected function rewriteQuery($query, $prefix = '')
    {
        if ($this->isDropQuery($query) || $this->isQueryOfType($query, 'CREATE')) {
            // Do not rewrite DROP and DROP queries as these are not supported
            // by the creator.
            $result  = new \stdClass();
            $result->query = $query;
            $result->params = array();
            return $result;
        }
        $parser = new Parser();
        $parsed = $parser->parse($query);

        $params = array();
        $isDelete = isset($parsed['DELETE']);
        if ($isDelete) {
            // The creator does not handle DELETE statements correctly.
            // Therefore, simulate a SELECT and correct the statement afterwards.
            $simulated = $parser->parse('SELECT * FROM DUAL');
            unset($simulated['FROM']);
            unset($parsed['DELETE']);
            // Prepend the dummy SELECT.
            $parsed = $simulated + $parsed;
        }
        if (isset($parsed['INSERT'])) {
            // Assign the first INSERT entry. Otherwise the creator seems to fail
            // when creating the statement.
            $parsed['INSERT'] = current($parsed['INSERT']);
            if (isset($parsed['INSERT']['columns']) && is_array($parsed['INSERT']['columns'])) {
                $parsed['INSERT']['columns'] = $this->quoteIdentifiers($parsed['INSERT']['columns']);
            }
        }
        if (isset($parsed['VALUES'])) {
            foreach ($parsed['VALUES'] as $recordIndex => $record) {
                /* @var $record array(string=>mixed) */
                $conversion = $this->convertLiteralsToParams($record['data'], $prefix . 'VALUES' . $recordIndex);
                $parsed['VALUES'][$recordIndex]['data'] = $conversion->parts;
                $params = $params + $conversion->params;
            }
        }
        if (isset($parsed['SELECT'])) {
            $parsed['SELECT'] = $this->removeBracketExpressions($parsed['SELECT']);
        }
        foreach (array('SELECT', 'FROM', 'UPDATE', 'SET', 'WHERE', 'GROUP', 'ORDER', 'LIMIT') as $partName) {
            /* @var $partName string */
            if (!isset($parsed[$partName])) {
                continue;
            }
            $parsed[$partName] = $this->quoteIdentifiers($parsed[$partName]);
            $conversion = $this->convertLiteralsToParams($parsed[$partName], $prefix . $partName);
            $parsed[$partName] = $conversion->parts;
            $params = $params + $conversion->params;
        }
        if (isset($parsed['WHERE'])) {
            $parsed['WHERE'] = $this->splitLargeInLists($parsed['WHERE']);
            $conversion = $this->resolveSubQueries($parsed['WHERE'], $prefix . 'SUB');
            $parsed['WHERE'] = $conversion->parts;
            $params = $params + $conversion->params;
        }
        $creator = new Creator();
        $result  = new \stdClass();
        $result->query = $creator->create($parsed);
        $result->params = $params;
        if ($isDelete) {
            // Correct DELETE queries by replacing the SELECT * part.
            $result->query = 'DELETE ' . substr($result->query, strlen('SELECT * '));
        }
        return $result;
    }

    /**
     * Generates SQL for all sub queries in the provided WHERE parts.
     *
     * This is a workaround as the creator does not handle sub queries in
     * bracket WHERE parts correctly.
     *
     * This method returns an object that has the following attributes:
     *
     * # parts  - array(array(string=>mixed)) - The modified parts.
     * # params - array(string=>mixed) - Additional query parameters.
     *
     * @param array(array(string=>mixed)) $parts
     * @param string $prefix A prefix for parameter names.
     * @return stdClass
     */
    protected function resolveSubQueries(array $parts, $prefix)
    {
        $result = new stdClass();
        $result->params = array();
        foreach (array_keys($parts) as $index) {
            /* @var $index integer */
            if ($parts[$index]['expr_type'] === 'subquery') {
                $query = $parts[$index]['base_expr'];
                if (strpos($query, '(') === 0) {
                    // Query is enclosed by brackets, which must be removed.
                    $query = trim($query);
                    $query = substr($query, 1, -1);
                }
                $query = trim($query);
                $subQuery = $this->rewriteQuery($query, $prefix);
                $result->params = $result->params + $subQuery->params;
                $parts[$index] = array(
                    'expr_type' => 'const',
                    'base_expr' => '(' . $subQuery->query . ')',
                    'sub_tree'  => false
                );
            } else if (is_array($parts[$index]['sub_tree'])) {
                $conversion = $this->resolveSubQueries($parts[$index]['sub_tree'], $prefix . '_');
                $result->params = $result->params + $conversion->params;
                $parts[$index]['sub_tree'] = $conversion->parts;
            }
        }
        $result->parts = $parts;
        return $result;
    }

    /**
     * Oracle does not allow IN() lists with more than 1000 expressions.
     *
     * Therefore, these lists are split into multiple ones.
     *
     * @param array(array(string=>mixed)) $parts
     * @return array(array(string=>mixed))
     */
    protected function splitLargeInLists(array $parts)
    {
        foreach (array_keys($parts) as $index) {
            /* @var $index integer */
            if ($parts[$index]['expr_type'] === 'in-list' && count($parts[$index]['sub_tree']) > 1000) {
                $colRef       = $parts[$index - 2];
                $listOperator = $parts[$index - 1];
                $items        = $parts[$index]['sub_tree'];
                $condition    = $this->splitList($colRef, $listOperator, $items);
                // Replace the original expression by the new version.
                $parts[$index - 2] = $condition;
                unset($parts[$index - 1]);
                unset($parts[$index]);
            }
        }
        return array_values($parts);
    }

    /**
     * Splits an IN list with more than 1000 item into multiple
     * ones that are connected by OR expressions.
     *
     * Example:
     * (x IN ([first 1000 items]) OR x IN ([next 1000 items]))
     *
     * @param array(string=>mixed) $colRef
     * @param array(string=>mixed) $listOperator
     * @param array(mixed) $items
     * @return array(string=>mixed)
     */
    protected function splitList($colRef, $listOperator, $items)
    {
        $expressionChunks = array_chunk($items, 1000);
        // Build an expression that uses multiple lists:
        // (x IN (...) OR x IN (...))
        $condition = array(
            'expr_type' => 'bracket_expression',
            'sub_tree' => array()
        );
        $orExpression = array(
            'expr_type' => 'operator',
            'base_expr' => 'OR',
            'sub_tree' => false
        );
        foreach ($expressionChunks as $chunk) {
            /* var $chunk array(string=>mixed) */
            $condition['sub_tree'][] = $colRef;
            $condition['sub_tree'][] = $listOperator;
            $condition['sub_tree'][] = array(
                'expr_type' => 'in-list',
                'sub_tree' => $chunk
            );
            $condition['sub_tree'][] = $orExpression;
        }
        // Remove the last OR, which is not followed by another expression.
        unset($condition['sub_tree'][count($condition['sub_tree']) - 1]);
        return $condition;
    }

    /**
     * Removes bracket expressions from the provided query parts.
     *
     * This might be necessary as the creator is not able to handle these
     * expressions in the SELECT part.
     *
     * @param array(array(string=>mixed)) $parts
     * @return array(array(string=>mixed))
     */
    protected function removeBracketExpressions(array $parts)
    {
        $replace = array();
        $originalKeys = array_keys($parts);
        foreach ($originalKeys as $index) {
            /* @var $index integer */
            if ($parts[$index]['expr_type'] === 'bracket_expression') {
                // Move up the sub tree that is stored in the brackets.
                // The sub tree may consist of several expressions.
                $replace[$index] = $parts[$index]['sub_tree'];
                unset($parts[$index]);
            }
        }
        if (count($replace) === 0) {
            // Nothing to replace.
            return $parts;
        }
        $newParts = array();
        foreach ($originalKeys as $index) {
            /* @var $index integer */
            if (isset($parts[$index])) {
                // The previous value can be used.
                $newParts[] = $parts[$index];
            } else {
                // Insert all sub tree elements at the new position.
                $newParts = array_merge($newParts, $replace[$index]);
            }
        }
        return $newParts;
    }

    /**
     * Replaces literals by parameters that can be used with prepared
     * statements.
     *
     * Returns an object with the following attributes:
     *
     * * parts  - The rewritten query parts.
     * * params - Map from parameter name to parameter value.
     *
     * @param array(array(string=>mixed)) $parts
     * @param string $prefix Prefix for the parameters.
     * @return stdClass
     */
    protected function convertLiteralsToParams(array $parts, $prefix)
    {
        $params = array();
        foreach (array_keys($parts) as $index) {
            /* @var $index integer */
            if ($parts[$index]['expr_type'] === 'const') {
                $literal = $parts[$index]['base_expr'];
                if ($literal === 'NULL') {
                    // Do not touch the NULL keyword in expressions
                    // like "column IS NULL".
                    continue;
                }
                // Remove the surrounding quotes...
                $literal = trim($literal, "'");
                // ... and revert the quoting.
                $literal = stripcslashes($literal);
                // Replace the literal by a parameter...
                $paramName = 'p_' . $prefix . '_' . count($params);
                $parts[$index]['base_expr'] = ':' . $paramName;
                // ... and add the parameter to the map.
                $params[$paramName] = $literal;
            } else if (in_array($parts[$index]['expr_type'], array('bracket_expression', 'expression'))) {
                // Sub tree must be processed.
                $subTree = $parts[$index]['sub_tree'];
                $subTreeConversion = $this->convertLiteralsToParams($subTree, $prefix . '_' . $index);
                $parts[$index]['sub_tree'] = $subTreeConversion->parts;
                $params = $params + $subTreeConversion->params;
            }
        }
        $conversion = new \stdClass();
        $conversion->parts  = $parts;
        $conversion->params = $params;
        return $conversion;
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
            if (!isset($parts[$index]['expr_type'])) {
                continue;
            }
            if ($parts[$index]['expr_type'] === 'pos') {
                // A column is referenced via its positional number.
                // It must not be quoted, but the expression type is changed
                // as the creator cannot handle positional references natively.
                $parts[$index]['expr_type'] = 'colref';
            } else if ($parts[$index]['expr_type'] === 'colref' && $parts[$index]['base_expr'] !== '*') {
                $parts[$index]['base_expr'] = $this->quoteIdentifier($parts[$index]['base_expr']);
            } else if ($parts[$index]['expr_type'] === 'table') {
                $parts[$index]['table'] = $this->quoteIdentifier($parts[$index]['table']);
                if (isset($parts[$index]['ref_clause']) && is_array($parts[$index]['ref_clause'])) {
                    // Join detected.
                    $parts[$index]['ref_clause'] = $this->quoteIdentifiers($parts[$index]['ref_clause']);
                }
            } else if (in_array($parts[$index]['expr_type'], array('bracket_expression', 'expression'))) {
                // Sub tree must be processed.
                $parts[$index]['sub_tree'] = $this->quoteIdentifiers($parts[$index]['sub_tree']);
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
     * Checks if the provided query is a DROP query.
     *
     * @param string $query
     * @return boolean
     */
    protected function isDropQuery($query)
    {
        return $this->isQueryOfType($query, 'DROP');
    }

    /**
     * Checks if $query is a SELECT query.
     *
     * @param string $query
     * @return boolean
     */
    protected function isSelectQuery($query)
    {
        return $this->isQueryOfType($query, 'SELECT');
    }

    /**
     * Checks if the query is of the provided type.
     *
     * Example:
     *
     *     $this->isQueryOfType('SELECT * FROM DUAL', 'SELECT');
     *
     * @param string $query
     * @param string $type
     * @return boolean
     */
    protected function isQueryOfType($query, $type)
    {
        return strpos(ltrim($query), $type) === 0;
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

<?php

/**
 * Tests the Oracle SQL access layer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_OracleSqlAdapterTest extends \Erfurt_OracleTestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_OracleSqlAdapter
     */
    protected $adapter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->adapter = new Erfurt_Store_Adapter_Oracle_OracleSqlAdapter($this->connection);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter = null;
        parent::tearDown();
    }

    /**
     * Checks if createTable() can be used to create a simple table
     * without primary key or auto increment columns.
     */
    public function testCreateTableCreatesSimpleTable()
    {
        $columns = array(
            'name' => 'VARCHAR(255) NOT NULL',
            'age'  => 'INT DEFAULT NULL'
        );

        $this->adapter->createTable('test_simple', $columns);

        $this->assertTableExists('test_simple');
    }

    /**
     * Ensures that createTable() can be used to create a table with
     * auto increment column.
     */
    public function testCreateTableCreatesTableWithAutoIncrementColumn()
    {
        $columns = array(
            'id'  => 'INT AUTO_INCREMENT',
            'age' => 'INT DEFAULT NULL'
        );

        $this->adapter->createTable('test_auto_increment', $columns);

        $this->assertTableExists('test_auto_increment');

    }

    /**
     * Checks if createTable() can be used to create a table with
     * primary key.
     */
    public function testCreateTableCreatesTableWithPrimaryKey()
    {
        $columns = array(
            'name' => 'VARCHAR(255) PRIMARY KEY NOT NULL',
            'age'  => 'INT DEFAULT NULL'
        );

        $this->adapter->createTable('test_simple', $columns);

        $this->assertTableExists('test_simple');
    }

    /**
     * Checks if listTables() returns all table names (if no further parameters
     * have been provided).
     */
    public function testListTablesReturnsTableNames()
    {
        $columns = array(
            'name' => 'VARCHAR(255) NOT NULL',
            'age'  => 'INT DEFAULT NULL'
        );

        $this->adapter->createTable('test_one', $columns);
        $this->adapter->createTable('test_two', $columns);
        $this->adapter->createTable('test_three', $columns);

        $names = $this->adapter->listTables();

        $this->assertInternalType('array', $names);
        $this->assertContains('test_one', $names);
        $this->assertContains('test_two', $names);
        $this->assertContains('test_three', $names);
    }

    /**
     * Checks if listTables() returns only those tables whose prefix is
     * equal to the provided one.
     */
    public function testListTablesReturnsOnlyTablesWithProvidedPrefix()
    {
        $columns = array(
            'name' => 'VARCHAR(255) NOT NULL',
            'age'  => 'INT DEFAULT NULL'
        );

        $this->adapter->createTable('test_demo1', $columns);
        $this->adapter->createTable('test_demo2', $columns);
        $this->adapter->createTable('test_other', $columns);

        $names = $this->adapter->listTables('test_demo');

        $this->assertInternalType('array', $names);
        $this->assertContains('test_demo1', $names);
        $this->assertContains('test_demo2', $names);
        $this->assertNotContains('test_other', $names);
    }

    /**
     * Checks if lastInsertId() returns the ID of the record that was
     * inserted last.
     */
    public function testLastInsertIdReturnsIdOfLastInsertQuery()
    {
        $columns = array(
            'id'  => 'INT AUTO_INCREMENT',
            'age' => 'INT DEFAULT NULL'
        );
        $this->adapter->createTable('test_id', $columns);

        $this->adapter->sqlQuery('INSERT INTO test_id (age) VALUES (27)');
        $id = $this->adapter->lastInsertId();

        $this->assertInternalType('integer', $id);
        $statement = $this->connection->prepare('SELECT * FROM test_id WHERE id=:id');
        $statement->execute(array('id' => $id));
        $rows = $statement->fetchAll();
        $this->assertCount(1, $rows);
    }

    /**
     * Checks if sqlQuery() returns the results of a select query.
     */
    public function testSqlQueryReturnsResultOfSelectQuery()
    {
        $columns = array(
            'name' => 'VARCHAR(255)',
            'age'  => 'INT DEFAULT NULL'
        );
        $this->adapter->createTable('test_data', $columns);

        $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES (\'Test\', 42)');
        $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES (\'Demo\', 25)');

        $results = $this->adapter->sqlQuery('SELECT * FROM test_data');

        $this->assertInternalType('array', $results);
        $this->assertContains(array('name' => 'Test', 'age' => 42), $results);
        $this->assertContains(array('name' => 'Demo', 'age' => 25), $results);
    }

    /**
     * Ensures that sqlQuery() applies the provided limit.
     */
    public function testSqlQueryAppliesLimit()
    {
        $columns = array(
            'name' => 'VARCHAR(255)',
            'age'  => 'INT DEFAULT NULL'
        );
        $this->adapter->createTable('test_data', $columns);

        for ($i = 0; $i < 20; $i++) {
            $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES (\'Test\', ' . $i . ')');
        }

        $results = $this->adapter->sqlQuery('SELECT * FROM test_data', 10);

        $this->assertInternalType('array', $results);
        $this->assertCount(10, $results);
    }

    /**
     * Ensures that sqlQuery() applies the provided offset.
     */
    public function testSqlQueryAppliesOffset()
    {
        $columns = array(
            'name' => 'VARCHAR(255)',
            'age'  => 'INT DEFAULT NULL'
        );
        $this->adapter->createTable('test_data', $columns);

        for ($i = 0; $i < 20; $i++) {
            $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES (\'Test\', ' . $i . ')');
        }

        $results = $this->adapter->sqlQuery('SELECT * FROM test_data ORDER BY age ASC', 10, 5);

        $this->assertInternalType('array', $results);
        foreach ($results as $row) {
            /* @var $row array(string=>mixed) */
            $this->assertInternalType('array', $row);
            $this->assertArrayHasKey('age', $row);
            $this->assertGreaterThanOrEqual(5, $row['age']);
        }
    }

    /**
     * Checks if sqlQuery() can handle aliases in MySQL style, for example
     * "SELECT * FROM data AS d".
     */
    public function testSqlQueryCanHandleTableAliases()
    {
        $columns = array(
            'name' => 'VARCHAR(255)',
            'age'  => 'INT DEFAULT NULL'
        );
        $this->adapter->createTable('test_data', $columns);
        $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES (\'Test\', 42)');

        $result = $this->adapter->sqlQuery('SELECT d.name FROM test_data AS d');

        $this->assertInternalType('array', $result);
        $this->assertContains(array('name' => 'Test'), $result);
    }

    /**
     * Checks if the adapter can handle the column names "model" and "resource"
     * in the table definition and in queries.
     */
    public function testAdapterCanHandleModelAndResourceColumnNamesInQueries()
    {
        $columns = array(
            'model'    => 'VARCHAR(255)',
            'resource' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);

        $result = $this->adapter->sqlQuery('SELECT model, resource FROM test_data');

        $this->assertInternalType('array', $result);
    }

    /**
     * Checks if the adapter can handle aliased variables (reserved words) in WHERE clauses.
     */
    public function testAdapterCanHandleAliasedReservedWordVariablesInWhereClause()
    {
        $columns = array(
            'resource' => 'VARCHAR(255)',
            'model'    => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);
        $this->adapter->sqlQuery('INSERT INTO test_data (resource, model) VALUES (\'Test\', \'42\')');

        $result = $this->adapter->sqlQuery('SELECT * FROM test_data AS d WHERE d.resource=\'Test\' AND d.model=\'42\'');

        $this->assertInternalType('array', $result);
        $this->assertContains(array('resource' => 'Test', 'model' => '42'), $result);
    }

    /**
     * Checks if createTable() overwrites a table with the same name if it already exists.
     */
    public function testCreateTableOverwritesPreviousTable()
    {
        $columns = array(
            'name' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);
        $columns = array(
            'id' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);

        $this->setExpectedException(null);
        $this->adapter->sqlQuery('INSERT INTO test_data (id) VALUES (\'hello\')');
    }

    /**
     * Checks if the adapter is able to handle quoted single quote characters
     * in queries.
     */
    public function testAdapterCanHandleQuotedSingleQuotes()
    {
        $columns = array(
            'name' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);

        $this->adapter->sqlQuery('INSERT INTO test_data (name) VALUES (\'hello \\\' quote\')');
        $result = $this->adapter->sqlQuery('SELECT * FROM test_data WHERE name=\'hello \\\' quote\'');

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
    }

    /**
     * Ensures that the adapter can handle condition parts in the WHERE section, that
     * are grouped via brackets.
     */
    public function testAdapterCanHandleGroupedPartsInWhereSection()
    {
        $columns = array(
            'name' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);

        $result = $this->adapter->sqlQuery('SELECT * FROM test_data WHERE (name=\'Matthias\' OR name=\'Max\')');

        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    /**
     * Checks if the adapter can handle DELETE queries.
     */
    public function testAdapterCanHandleDeleteQueries()
    {
        $columns = array(
            'name' => 'VARCHAR(255)'
        );
        $this->adapter->createTable('test_data', $columns);

        $this->setExpectedException(null);
        $this->adapter->sqlQuery('DELETE FROM test_data WHERE name=\'Matthias\'');
    }

    /**
     * Asserts that a table with the provided name exists.
     *
     * @param string $name
     */
    protected function assertTableExists($name)
    {
        $names = $this->connection->getSchemaManager()->listTableNames();
        $this->assertContains(strtoupper($name), $names);
    }

}

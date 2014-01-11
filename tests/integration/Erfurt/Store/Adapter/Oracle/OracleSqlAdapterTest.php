<?php

/**
 * Tests the Oracle SQL access layer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 * @Group Oracle
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
        $statement->execute(array('id', $id));
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

        $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES ("Test", 42)');
        $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES ("Demo", 25)');

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
            $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES ("Test", ' . $i . ')');
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
            $this->adapter->sqlQuery('INSERT INTO test_data (name, age) VALUES ("Test", ' . $i . ')');
        }

        $results = $this->adapter->sqlQuery('SELECT * FROM test_data ORDER BY age ASC', 10, 5);

        $this->assertInternalType('array', $results);
        foreach ($results as $row) {
            /* @var $row array(string=>mixed) */
            $this->assertInternalType('array', $row);
            $this->assertArrayHasKey('age', $row);
            $this->assertGreaterThan(5, $row['age']);
        }
    }

    /**
     * Asserts that a table with the provided name exists.
     *
     * @param string $name
     */
    protected function assertTableExists($name)
    {
        $names = $this->connection->getSchemaManager()->listTableNames();
        $this->assertContains($name, $names);
    }

}

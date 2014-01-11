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

    }

    /**
     * Ensures that createTable() can be used to create a table with
     * auto increment column.
     */
    public function testCreateTableCreatesTableWithAutoIncrementColumn()
    {

    }

    /**
     * Checks if createTable() can be used to create a table with
     * primary key.
     */
    public function testCreateTableCreatesTableWithPrimaryKey()
    {

    }

    /**
     * Checks if listTables() returns all table names (if no further parameters
     * have been provided).
     */
    public function testListTablesReturnsTableNames()
    {

    }

    /**
     * Checks if listTables() returns only those tables whose prefix is
     * equal to the provided one.
     */
    public function testListTablesReturnsOnlyTablesWithProvidedPrefix()
    {

    }

    /**
     * Checks if lastInsertId() returns the ID of the record that was
     * inserted last.
     */
    public function testLastInsertIdReturnsIdOfLastInsertQuery()
    {

    }

    /**
     * Checks if sqlQuery() returns the results of a select query.
     */
    public function testSqlQueryReturnsResultOfSelectQuery()
    {

    }

    /**
     * Ensures that sqlQuery() applies the provided limit.
     */
    public function testSqlQueryAppliesLimit()
    {

    }

    /**
     * Ensures that sqlQuery() applies the provided offset.
     */
    public function testSqlQueryAppliesOffset()
    {

    }

}

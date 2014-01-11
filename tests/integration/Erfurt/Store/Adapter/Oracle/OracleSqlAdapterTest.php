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

    public function testCreateTableCreatesSimpleTable()
    {

    }

    public function testCreateTableCreatesTableWithAutoIncrementColumn()
    {

    }

    public function testCreateTableCreatesTableWithPrimaryKey()
    {

    }

    public function testListTablesReturnsTableNames()
    {

    }

    public function testListTablesReturnsOnlyTablesWithProvidedPrefix()
    {

    }

    public function testLastInsertIdReturnsIdOfLastInsertQuery()
    {

    }

    public function testSqlQueryReturnsResultOfSelectQuery()
    {

    }

    public function testSqlQueryAppliesLimit()
    {

    }

    public function testSqlQueryAppliesOffset()
    {
        
    }

}

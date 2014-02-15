<?php

/**
 * Tests the batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_BatchProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_BatchProcessor
     */
    protected $processor = null;

    /**
     * Test helper that is used to set up the environment.
     *
     * @var \Erfurt_OracleTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        $this->processor = new Erfurt_Store_Adapter_Oracle_BatchProcessor($this->helper->getConnection());
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->processor = null;
        $this->helper->cleanUp();
        parent::tearDown();
    }

    public function testProcessorCanHandleEmptyTripleList()
    {

    }

    public function testProcessorStoresSingleTriple()
    {

    }

    public function testProcessorStoresListOfTriples()
    {

    }

    public function testProcessorStoresSingleTripleWithLargeLiteral()
    {

    }

    public function testProcessorStoresListOfTriplesWithLargeLiteral()
    {

    }

}

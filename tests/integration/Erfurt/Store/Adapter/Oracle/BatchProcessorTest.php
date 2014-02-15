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

    /**
     * Checks if the batch processor can handle an empty triple list.
     */
    public function testProcessorCanHandleEmptyTripleList()
    {

    }

    /**
     * Ensures that the batch processor is able to store a single triple.
     */
    public function testProcessorStoresSingleTriple()
    {

    }

    /**
     * Checks if the processor can store a list of triples.
     */
    public function testProcessorStoresListOfTriples()
    {

    }

    /**
     * Ensures that the batch processor is able to store a single
     * with large literal object.
     */
    public function testProcessorStoresSingleTripleWithLargeLiteral()
    {

    }

    /**
     * Checks if the processor can store a list of triples with large
     * literal objects.
     */
    public function testProcessorStoresListOfTriplesWithLargeLiteral()
    {

    }

}

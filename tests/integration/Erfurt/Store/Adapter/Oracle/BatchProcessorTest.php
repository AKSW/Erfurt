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
        $this->processor->persist(array());

        $this->assertNumberOfTriples(0);
    }

    /**
     * Ensures that the batch processor is able to store a single triple.
     */
    public function testProcessorStoresSingleTriple()
    {
        $triple = $this->createTriple();

        $this->processor->persist(array($triple));

        $this->assertNumberOfTriples(1);
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
        $triple = $this->createTriple(4200);

        $this->processor->persist(array($triple));

        $this->assertNumberOfTriples(1);
    }

    /**
     * Checks if the processor can store a list of triples with large
     * literal objects.
     */
    public function testProcessorStoresListOfTriplesWithLargeLiteral()
    {

    }

    /**
     * Asserts that $expectedNumber triples are stored.
     *
     * @param integer $expectedNumber
     */
    protected function assertNumberOfTriples($expectedNumber)
    {

    }

    /**
     * Creates a triple with literal object.
     *
     * @param integer $objectLiteralSite The size of the object literal in bytes.
     * @return Erfurt_Store_Adapter_Sparql_Triple
     */
    protected function createTriple($objectLiteralSite = 100)
    {
        return new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/subject/' . uniqid('s', true),
            'http://example.org/predicate/' . uniqid('p', true),
            array(
                'type'  => 'literal',
                'value' => str_repeat('x', $objectLiteralSite)
            )
        );
    }

}

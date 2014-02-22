<?php

/**
 * Tests the batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_StoredProcedureBatchProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_StoredProcedureBatchProcessor
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
        $this->processor = new Erfurt_Store_Adapter_Oracle_StoredProcedureBatchProcessor($this->helper->getConnection());
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
     * Ensures that the batch processor is able to store a single quad.
     */
    public function testProcessorStoresSingleQuad()
    {
        $quad = $this->createQuad();

        $this->processor->persist(array($quad));

        $this->assertNumberOfTriples(1);
    }

    /**
     * Checks if the processor can store a list of quads.
     */
    public function testProcessorStoresListOfQuads()
    {
        $quads = $this->createQuads(20);

        $this->processor->persist($quads);

        $this->assertNumberOfTriples(count($quads));
    }

    /**
     * Checks if persist() can be used multiple times.
     */
    public function testProcessorCanStoreMultipleListsOfQuads()
    {
        $this->processor->persist($this->createQuads(20));
        $this->processor->persist($this->createQuads(20));

        $this->assertNumberOfTriples(40);
    }

    /**
     * Checks if persist() can handle quad lists of different sizes.
     */
    public function testProcessorCanBeUsedWithQuadListsOfDifferentSizes()
    {
        $this->processor->persist($this->createQuads(5));
        $this->processor->persist($this->createQuads(20));
        $this->processor->persist($this->createQuads(10));
        $this->processor->persist($this->createQuads(5));

        $this->assertNumberOfTriples(40);
    }

    /**
     * Ensures that the batch processor is able to store a single
     * quad with large literal object.
     */
    public function testProcessorStoresSingleQuadWithLargeLiteral()
    {
        $quad = $this->createQuad(4200);

        $this->processor->persist(array($quad));

        $this->assertNumberOfTriples(1);
    }

    /**
     * Checks if the processor can store a list of quads with large
     * literal objects.
     */
    public function testProcessorStoresListOfQuadsWithLargeLiteral()
    {
        $quads = $this->createQuads(20, 4200);

        $this->processor->persist($quads);

        $this->assertNumberOfTriples(count($quads));
    }

    /**
     * Asserts that $expectedNumber triples are stored.
     *
     * @param integer $expectedNumber
     */
    protected function assertNumberOfTriples($expectedNumber)
    {
        $this->assertEquals($expectedNumber, $this->helper->countTriples());
    }

    /**
     * Creates a list of $number quads.
     *
     * @param integer $number
     * @param integer $objectLiteralSize
     * @return array(Erfurt_Store_Adapter_Sparql_Quad)
     */
    protected function createQuads($number, $objectLiteralSize = 100)
    {
        $quads = array();
        for ($i = 0; $i < $number; $i++) {
            $quads[] = $this->createQuad($objectLiteralSize);
        }
        return $quads;
    }

    /**
     * Creates a quad with literal object.
     *
     * @param integer $objectLiteralSite The size of the object literal in bytes.
     * @return Erfurt_Store_Adapter_Sparql_Quad
     */
    protected function createQuad($objectLiteralSite = 100)
    {
        return new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject/' . uniqid('s', true),
            'http://example.org/predicate/' . uniqid('p', true),
            array(
                'type'  => 'literal',
                'value' => str_repeat('x', $objectLiteralSite)
            ),
            'http://example.org/graph'
        );
    }

}

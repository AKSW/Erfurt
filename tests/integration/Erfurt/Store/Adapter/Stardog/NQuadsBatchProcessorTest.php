<?php

/**
 * Tests the NQuads batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 * @group Stardog
 */
class Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessor
     */
    protected $processor = null;

    /**
     * Test helper that is used to initialize the environment.
     *
     * @var \Erfurt_StardogTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper    = new Erfurt_StardogTestHelper();
        $client          = $this->helper->getDataAccessClient();
        $this->processor = new Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessor($client);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->processor = null;
        $this->helper->cleanUp();
        $this->helper = null;
        parent::tearDown();
    }

    /**
     * Checks if the batch processor implements the required interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Erfurt_Store_Adapter_Sparql_BatchProcessorInterface', $this->processor);
    }

    /**
     * Checks if persist() can handle an empty quad list.
     */
    public function testPersistCanHandleEmptyQuadList()
    {
        $this->setExpectedException(null);
        $this->processor->persist(array());
    }

    /**
     * Checks if persist() adds a singe quad.
     */
    public function testPersistAddsSingleQuad()
    {
        $quad = new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'  => 'uri',
                'value' => 'http://example.org/object'
            ),
            'http://example.org/graph'
        );

        $this->processor->persist(array($quad));

        $this->assertNumberOfTriples(1);
    }

    /**
     * Checks if persist() adds multiple quads.
     */
    public function testPersistAddsMultipleQuads()
    {
        $quads = array(
            new Erfurt_Store_Adapter_Sparql_Quad(
                'http://example.org/subject1',
                'http://example.org/predicate1',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object1'
                ),
                'http://example.org/graph'
            ),
            new Erfurt_Store_Adapter_Sparql_Quad(
                'http://example.org/subject2',
                'http://example.org/predicate2',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object2'
                ),
                'http://example.org/graph'
            ),
        );

        $this->processor->persist($quads);

        $this->assertNumberOfTriples(2);
    }

    /**
     * Ensures that persist() adds the triples to the correct graphs.
     */
    public function testPersistAssignsQuadsToCorrectGraphs()
    {
        // Use quads that are assigned to multiple graphs.
        $quads = array(
            new Erfurt_Store_Adapter_Sparql_Quad(
                'http://example.org/subject1',
                'http://example.org/predicate1',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object1'
                ),
                'http://example.org/graph1'
            ),
            new Erfurt_Store_Adapter_Sparql_Quad(
                'http://example.org/subject2',
                'http://example.org/predicate2',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object2'
                ),
                'http://example.org/graph2'
            ),
        );

        $this->processor->persist($quads);

        $this->assertNumberOfTriplesInGraph('http://example.org/graph1', 1);
        $this->assertNumberOfTriplesInGraph('http://example.org/graph2', 1);
    }

    /**
     * Checks if the batch processor encodes umlauts correctly.
     */
    public function testPersistEncodeUmlautsCorrectly()
    {
        $quad = new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'  => 'literal',
                'value' => 'hello wörld'
            ),
            'http://example.org/graph'
        );

        $this->processor->persist(array($quad));

        $this->assertNumberOfRowsSelected(1, 'SELECT * WHERE { ?s ?p "hello wörld" . }');
    }

    /**
     * Asserts that the given graph contains the expected number of triples.
     *
     * @param string $graph
     * @param integer $expected
     */
    protected function assertNumberOfTriplesInGraph($graph, $expected)
    {
        $query  = 'SELECT * FROM <' . $graph . '> WHERE { ?s ?p ?o . }';
        $this->assertNumberOfRowsSelected($expected, $query);
    }

    /**
     * Asserts that the provided SPARQL query selects the expected number of rows.
     *
     * @param integer $expected
     * @param string $query
     */
    protected function assertNumberOfRowsSelected($expected, $query)
    {
        $result = $this->helper->getApiClient()->query(array('query' => $query));
        $this->assertTrue(isset($result['results']['bindings']), 'Unexpected result structure.');
        $numberOfTriples = count($result['results']['bindings']);
        $this->assertEquals($expected, $numberOfTriples);
    }

    /**
     * Asserts that the whole database contains the expected number of triples.
     *
     * @param integer $expected
     */
    protected function assertNumberOfTriples($expected)
    {
        $this->assertEquals($expected, $this->helper->getApiClient()->size());
    }

}

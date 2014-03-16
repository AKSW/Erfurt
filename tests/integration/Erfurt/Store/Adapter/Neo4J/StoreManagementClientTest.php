<?php

/**
 * Tests the management client.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 * @group Neo4J
 */
class Erfurt_Store_Adapter_Neo4J_StoreManagementClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Neo4J_StoreManagementClient
     */
    protected $client = null;

    /**
     * Helper object that is used to create the Stardog related objects.
     *
     * @var \Erfurt_Neo4JTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new Erfurt_Neo4JTestHelper();
        $this->client = $this->helper->getManagementClient();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->helper->cleanUp();
        $this->client = null;
        $this->helper = null;
        parent::tearDown();
    }

    /**
     * Checks if getNumberOfTriples() returns an integer value.
     */
    public function testGetNumberOfTriplesReturnsInteger()
    {
        $numberOfTriples = $this->client->getNumberOfTriples();

        $this->assertInternalType('integer', $numberOfTriples);
        $this->assertGreaterThanOrEqual(0, $numberOfTriples);
    }

    /**
     * Checks if clear() removes all existing triples.
     *
     * Please note: With an empty database this test shows only that clear()
     * is callable without errors, as no data is inserted before.
     */
    public function testClearRemovesAllTriples()
    {
        $this->client->clear();

        $this->assertEquals(0, $this->client->getNumberOfTriples());
    }

    /**
     * Checks if deleteMatchingTriples() is callable without errors.
     */
    public function testDeleteMatchingTriplesIsCallable()
    {
        $this->setExpectedException(null);
        $this->client->deleteMatchingTriples(
            'http://example.org/any-graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );
    }

    /**
     * Ensures that addTriple() is callable without errors.
     */
    public function testAddTripleIsCallable()
    {
        $this->setExpectedException(null);
        $this->client->addTriple(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_Triple(
                'http://example.org/graph',
                'http://example.org/predicate',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object'
                )
            )
        );
    }

    /**
     * Ensures that addTriple() does not create the same triple twice.
     */
    public function testAddTripleDoesNotCreateSameTripleTwice()
    {
        $this->client->clear();

        $triple = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/graph',
            'http://example.org/predicate',
            array(
                'type'  => 'uri',
                'value' => 'http://example.org/object'
            )
        );
        $this->client->addTriple('http://example.org/graph', $triple);
        $this->client->addTriple('http://example.org/graph', $triple);

        $this->assertEquals(1, $this->client->getNumberOfTriples());
    }

}

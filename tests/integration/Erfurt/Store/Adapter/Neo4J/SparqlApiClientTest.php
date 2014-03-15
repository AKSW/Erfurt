<?php

/**
 * Tests the Neo4J API client.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 13.03.14
 * @group Neo4J
 */
class Erfurt_Store_Adapter_Neo4J_SparqlApiClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Neo4J_SparqlApiClient
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
        $this->client = $this->helper->getSparqlApiClient();
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
     * Checks if the factory() method creates a service client.
     */
    public function testFactoryCreatesClient()
    {
        $client = \Erfurt_Store_Adapter_Neo4J_SparqlApiClient::factory(array('baseUrl' => 'http://not-important.here'));

        $this->assertInstanceOf('Erfurt_Store_Adapter_Neo4J_SparqlApiClient', $client);
    }

    /**
     * Checks if query() accepts a valid SPARQL query.
     */
    public function testQueryAcceptsValidSparqlQuery()
    {
        $this->setExpectedException(null);
        $this->client->query(array(
            'query' => 'SELECT * WHERE { ?s ?p ?o . }'
        ));
    }

    /**
     * Ensures that query() returns an array.
     */
    public function testQueryReturnsArray()
    {
        $result = $this->client->query(array(
            'query' => 'SELECT * WHERE { ?s ?p ?o . }'
        ));

        $this->assertInternalType('array', $result);
    }

    /**
     * Checks if insert() accepts a valid quad data set.
     */
    public function testInsertAcceptsQuadData()
    {
        $this->setExpectedException(null);
        $this->client->insert(array(
            'subject'   => 'http://example.org/subject',
            'predicate' => 'http://example.org/predicate',
            'object'    => 'http://example.org/object',
            'graph'     => 'http://example.org/graph'
        ));
    }

}

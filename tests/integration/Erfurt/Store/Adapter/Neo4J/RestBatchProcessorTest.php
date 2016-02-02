<?php

/**
 * Tests the batch processor that uses the REST API.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 19.05.14
 * @group Neo4J
 */
class Erfurt_Store_Adapter_Neo4J_RestBatchProcessorTest
    extends \Erfurt_Store_Adapter_Sparql_AbstractBatchProcessorTestCase
{

    /**
     * Test helper that is used to initialize the environment.
     *
     * @var \Erfurt_Neo4JTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        $this->helper = new Erfurt_Neo4JTestHelper();
        // Set up the connector as that clears the database.
        $this->helper->getSparqlConnector();
        parent::setUp();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->helper->cleanUp();
        $this->helper = null;
    }

    /**
     * Asserts that the whole database contains the expected number of triples.
     *
     * @param integer $expected
     */
    protected function assertNumberOfTriples($expected)
    {
        $this->assertEquals($expected, $this->helper->getManagementClient()->getNumberOfTriples());
    }

    /**
     * Executes the provided SPARQL query and returns the result in extended format.
     *
     * @param string $query
     * @return mixed
     */
    protected function executeSparqlQuery($query)
    {
        return $this->helper->getSparqlConnector()->query($query);
    }

    /**
     * Creates the batch processor that is used in the tests.
     *
     * @return Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
     */
    protected function createProcessor()
    {
        return new Erfurt_Store_Adapter_Neo4J_RestBatchProcessor($this->helper->getApiClient());
    }

}

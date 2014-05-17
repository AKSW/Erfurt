<?php

/**
 * Tests the Neo4J SPARQL connector.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 * @group Neo4J
 */
class Erfurt_Store_Adapter_Neo4J_Neo4JSparqlConnectorTest
    extends \Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorTestCase
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
     * Creates the SPARQL connector that will be tested.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    protected function createConnector()
    {
        return $this->helper->getSparqlConnector();
    }

    /**
     * Counts the number of triples in the store.
     *
     * @return integer
     */
    protected function countTriples()
    {
        return $this->helper->getManagementClient()->getNumberOfTriples();
    }

}

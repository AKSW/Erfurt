<?php

/**
 * Erfurt_Store_Adapter_Neo4J_ApiClientTest
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 17.05.14
 * @group Neo4J
 */
class Erfurt_Store_Adapter_Neo4J_ApiClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Neo4J_ApiClient
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
        $this->helper = new Erfurt_Neo4JTestHelper;
        $this->client = $this->helper->getApiClient();
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
        $client = \Erfurt_Store_Adapter_Neo4J_ApiClient::factory(array('baseUrl' => 'http://not-important.here'));

        $this->assertInstanceOf('Erfurt_Store_Adapter_Neo4J_ApiClient', $client);
    }

    /**
     * Checks if the client from the container has a service description.
     */
    public function testClientHasServiceDescription()
    {
        $this->assertNotNull($this->client->getDescription());
    }

    /**
     * Ensures that createUniqueNode() creates a new node if it does not already exist.
     */
    public function testCreateUniqueNodeCreatesNodeIfItDoesNotAlreadyExist()
    {
        $properties = array('term' => '<http://example.org/api-client-test');
        $nodeIdentifier = $this->client->createUniqueNode('api-client-test', uniqid('', true), $properties);

        $this->assertInternalType('string', $nodeIdentifier);
        $this->assertNotEmpty($nodeIdentifier);
    }

    /**
     * Ensures that createUniqueNode() returns the original identifier of a node if
     * it already exists.
     */
    public function testCreateUniqueNodeReturnsExistingNodeIfItAlreadyExists()
    {
        $id = uniqid('', true);
        $properties = array('term' => '<http://example.org/api-client-test');
        $first = $this->client->createUniqueNode('api-client-test', $id, $properties);
        $properties = array('term' => '<http://example.org/api-client-test2');
        $second = $this->client->createUniqueNode('api-client-test', $id, $properties);

        $this->assertEquals($first, $second);
    }

    /**
     * Ensures that createUniqueNode() returns different identifiers for different nodes.
     */
    public function testCreateUniqueNodeReturnsDifferentIdentifiersForDifferentNodes()
    {
        $properties = array('term' => '<http://example.org/api-client-test');
        $first = $this->client->createUniqueNode('api-client-test', uniqid('', true), $properties);
        $properties = array('term' => '<http://example.org/api-client-test2');
        $second = $this->client->createUniqueNode('api-client-test', uniqid('', true), $properties);

        $this->assertNotEquals($first, $second);
    }

}

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

}

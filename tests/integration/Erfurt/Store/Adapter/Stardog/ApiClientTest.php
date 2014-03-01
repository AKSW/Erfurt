<?php

/**
 * Tests the Stardog API client.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 * @group Stardog
 */
class Erfurt_Store_Adapter_Stardog_ApiClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Stardog_ApiClient
     */
    protected $client = null;

    /**
     * Helper object that is used to create the Stardog related objects.
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
        $this->helper = new Erfurt_StardogTestHelper();
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
        $client = \Erfurt_Store_Adapter_Stardog_ApiClient::factory(array('baseUrl' => 'http://not-important.here'));

        $this->assertInstanceOf('Erfurt_Store_Adapter_Stardog_ApiClient', $client);
    }

    /**
     * Checks if the client from the container has a service description.
     */
    public function testClientHasServiceDescription()
    {
        $this->assertNotNull($this->client->getDescription());
    }

    /**
     * Checks if the size() method returns an integer.
     */
    public function testSizeReturnsInteger()
    {
        $size = $this->client->size();

        $this->assertInternalType('integer', $size);
    }

}

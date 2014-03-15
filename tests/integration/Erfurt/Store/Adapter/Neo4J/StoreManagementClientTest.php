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

}

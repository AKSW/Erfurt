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

    /**
     * Checks if the query operation returns an array that contains the results.
     *
     * The concrete result values are not checked here.
     */
    public function testQueryReturnsResults()
    {
        $query   = 'SELECT * WHERE { ?subject ?predicate ?object }';
        $results = $this->client->query(array('query' => $query));

        $this->assertInternalType('array', $results);
    }

    /**
     * Checks if the explain operation returns some kind
     * of execution plan.
     */
    public function testExplainReturnsExecutionPlan()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object }';
        $plan  = $this->client->explain(array('query' => $query));

        $this->assertInternalType('string', $plan);
        $this->assertNotEmpty($plan);
    }

    /**
     * Checks if beginTransaction() returns a transaction ID.
     */
    public function testBeginTransactionReturnsTransactionId()
    {
        $id = $this->client->beginTransaction();

        $this->assertInternalType('string', $id);
        $this->assertNotEmpty($id);
    }

    /**
     * Ensures that commitTransaction() throws an exception if an invalid
     * transaction ID is passed.
     */
    public function testCommitTransactionThrowsExceptionIfInvalidIdIsPassed()
    {
        $this->setExpectedException('\Erfurt_Store_Adapter_Stardog_ApiClientException');
        $this->client->commitTransaction(array('transaction-id' => 'invalid'));
    }

    /**
     * Checks if commitTransaction() accepts a valid transaction ID.
     */
    public function testCommitTransactionAcceptsValidId()
    {
        $id = $this->client->beginTranaction();

        $this->setExpectedException(null);
        $this->client->commitTransaction(array('transaction-id' => $id));
    }

    /**
     * Checks if rollbackTransaction() accepts a valid transaction ID.
     */
    public function testRollbackTransactionAcceptsValidId()
    {
        $id = $this->client->beginTranaction();

        $this->setExpectedException(null);
        $this->client->rollbackTransaction(array('transaction-id' => $id));
    }

    /**
     * Ensures that clear() is callable without parameters.
     */
    public function testClearCanBeCalledWithoutGraphUri()
    {
        $this->setExpectedException(null);
        $this->client->clear();
    }

    /**
     * Checks if clear() accepts a graph URI as parameter.
     */
    public function testClearAcceptsGraphUri()
    {
        $this->setExpectedException(null);
        $this->client->clear(array('graph-uri' => 'http://example.org/my-graph'));
    }

}

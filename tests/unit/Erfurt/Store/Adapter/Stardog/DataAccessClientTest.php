<?php

/**
 * Tests the data access client.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_DataAccessClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Stardog_DataAccessClient
     */
    protected $client = null;

    /**
     * The mocked API client.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $apiClient = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->apiClient = $this->getMockBuilder('Erfurt_Store_Adapter_Stardog_ApiClient')
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->client = new Erfurt_Store_Adapter_Stardog_DataAccessClient($this->apiClient);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->client    = null;
        $this->apiClient = null;
        parent::tearDown();
    }

    /**
     * Checks if query() executes the provided SPARQL query (which means that it is passed
     * to the API client).
     */
    public function testQueryExecutesSparqlQuery()
    {
        $query = 'SELECT * WHERE { ?s ?p ?o . }';
        $this->apiClient->expects($this->once())
                        ->method('query')
                        ->with(array('query' => $query));

        $this->client->query($query);
    }

    /**
     * Checks if query() returns the result from the API client.
     */
    public function testQueryReturnsResultFromApiClient()
    {
        $simulatedResult = array('results' => array('bindings' => array()));
        $this->apiClient->expects($this->once())
                        ->method('query')
                        ->will($this->returnValue($simulatedResult));

        $result = $this->client->query('SELECT * WHERE { ?s ?p ?o . }');

        $this->assertEquals($simulatedResult, $result);
    }

    /**
     * Ensures that transactional() throws an exception if no valid callback is provided.
     */
    public function testTransactionalThrowsExceptionIfNoValidCallbackIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->client->transactional(new \stdClass());
    }

    /**
     * Ensures that transactional() starts and commits a transaction.
     */
    public function testTransactionalStartsAndCommitsTransaction()
    {
        $this->apiClient->expects($this->once())
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));
        $this->apiClient->expects($this->once())
                        ->method('commitTransaction')
                        ->with(array('transaction-id' => 't42'));

        $this->client->transactional(function() {});
    }

    /**
     * Ensures that transactional() performs a rollback if an exception
     * is thrown by the callback.
     */
    public function testTransactionPerformsRollbackIfExceptionIsThrown()
    {
        $this->apiClient->expects($this->once())
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));
        $this->apiClient->expects($this->once())
                        ->method('rollbackTransaction')
                        ->with(array('transaction-id' => 't42'));

        $this->setExpectedException('RuntimeException');
        $this->client->transactional(function() {
            throw new RuntimeException('Error within transaction.');
        });
    }

    /**
     * Checks if transactional() passes the data access client as first argument
     * to the callback.
     */
    public function testTransactionalPassesClientAsFirstArgumentToCallback()
    {
        $callback = $this->getMock('stdClass', array('__invoke'));
        $callback->expects($this->once())
                 ->method('__invoke')
                 ->with($this->isInstanceOf(get_class($this->client)));
        $this->apiClient->expects($this->any())
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));

        $this->client->transactional($callback);
    }

    /**
     * Checks if transactional() executes queries within a transaction.
     */
    public function testTransactionalExecutesQueriesWithInTransaction()
    {
        $constraint = $this->logicalAnd(
            $this->isType('array'),
            $this->arrayHasKey('transaction-id'),
            $this->contains('t42')
        );
        $this->apiClient->expects($this->once())
                        ->method('query')
                        ->with($constraint);
        $this->apiClient->expects($this->any())
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));

        $this->client->transactional(function ($client) {
            /* @var $client Erfurt_Store_Adapter_Stardog_DataAccessClient */
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Stardog_DataAccessClient', $client);
            $client->query('SELECT * WHERE { ?s ?p ?o . }');
        });
    }

    /**
     * Ensures that transactional() does not start another transaction if the provided callback
     * invokes transactional() again.
     */
    public function testTransactionalDoesNotStartMoreTransactionsIfCalledAgainFromCallback()
    {
        $this->apiClient->expects($this->once())
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));
        $this->apiClient->expects($this->once())
                        ->method('commitTransaction')
                        ->with(array('transaction-id' => 't42'));

        $this->client->transactional(function ($client) {
            /* @var $client Erfurt_Store_Adapter_Stardog_DataAccessClient */
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Stardog_DataAccessClient', $client);
            $client->transactional(function() {});
            $client->transactional(function() {});
        });
    }

    /**
     * Ensures that transactional() executes multiple transaction if it is invoked in
     * sequence (not nested).
     */
    public function testTransactionalStartsMultipleTransactionIfInvokedInSequence()
    {
        $this->apiClient->expects($this->exactly(2))
                        ->method('beginTransaction')
                        ->will($this->returnValue('t42'));
        $this->apiClient->expects($this->exactly(2))
                        ->method('commitTransaction')
                        ->with(array('transaction-id' => 't42'));

        $this->client->transactional(function () {});
        $this->client->transactional(function () {});
    }

}

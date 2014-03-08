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
     * Checks if query() executes the provided SPARQL query (which means that it is passed
     * to the API client).
     */
    public function testQueryExecutesSparqlQuery()
    {

    }

    /**
     * Checks if query() returns the result from the API client.
     */
    public function testQueryReturnsResultFromApiClient()
    {

    }

    /**
     * Ensures that transactional() throws an exception if no valid callback is provided.
     */
    public function testTransactionalThrowsExceptionIfNoValidCallbackIsPassed()
    {

    }

    /**
     * Ensures that transactional() starts and commits a transaction.
     */
    public function testTransactionalStartsAndCommitsTransaction()
    {

    }

    /**
     * Ensures that transactional() performs a rollback if an exception
     * is thrown by the callback.
     */
    public function testTransactionPerformsRollbackIfExceptionIsThrown()
    {

    }

    /**
     * Checks if transactional() passes the data access client as first argument
     * to the callback.
     */
    public function testTransactionalPassesClientAsFirstArgumentToCallback()
    {

    }

    /**
     * Checks if transactional() executes queries within a transaction.
     */
    public function testTransactionalExecutesQueriesWithInTransaction()
    {

    }

    /**
     * Ensures that transactional() does not start another transaction if the provided callback
     * invokes transactional() again.
     */
    public function testTransactionalDoesNotStartMoreTransactionIfCalledAgainFromCallback()
    {

    }

}

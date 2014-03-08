<?php

/**
 * Uses the low-level API client to provide a more advanced interface
 * that is used to read and manipulate data in a Stardog database.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_DataAccessClient
{

    /**
     * Creates a data access client that uses the provided API client.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_ApiClient $client)
    {

    }

    /**
     * Executes a SPARQL query and returns the result.
     *
     * Any type of SPARQL query is accepted (SELECT, ASK, UPDATE, DELETE, ...).
     * The returned result depends on the query type. No conversion or normalization
     * is applied.
     *
     * @param string $sparqlQuery
     * @return array|SimpleXMLElement
     */
    public function query($sparqlQuery)
    {

    }

    /**
     * Executes the provided callback within a transaction.
     *
     * The callback receives the DataAccessClient as argument.
     * If another transaction is requested within such a callback,
     * then the existing transaction will be used. No commit
     * or rollback will be performed when the sub-transaction
     * finishes as the main transactional call is responsible
     * for that.
     *
     * @param callback $callback
     * @throws InvalidArgumentException if no valid callback is passed.
     */
    public function transactional($callback)
    {

    }

}

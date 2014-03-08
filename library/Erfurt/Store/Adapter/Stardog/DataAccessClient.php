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
     * The low-level client that is used to interact with the triple store.
     *
     * @var Erfurt_Store_Adapter_Stardog_ApiClient
     */
    protected $apiClient = null;

    /**
     * ID of the running transaction or null if no transaction is active.
     *
     * @var string|null
     */
    protected $runningTransaction = null;

    /**
     * Creates a data access client that uses the provided API client.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_ApiClient $client)
    {
        $this->apiClient = $client;
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
        $arguments = array(
            'query' => $sparqlQuery
        );
        return $this->apiClient->query($this->withTransaction($arguments));
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
     * @throws Exception Any error from the executed callback.
     */
    public function transactional($callback)
    {
        if (!is_callable($callback)) {
            $message = __FUNCTION__ . '() expects a valid callback.';
            throw new \InvalidArgumentException($message);
        }
        if ($this->inTransaction()) {
            // A transaction is already active, therefore, this execution of transactional()
            // is not responsible for transaction management.
            call_user_func($callback, $this);
            return;
        }
        $this->beginTransaction();
        try {
            call_user_func($callback, $this);
            $this->commit();
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * Adds the current transaction ID to the given operation arguments.
     *
     * Does not change the arguments if no transaction is running.
     *
     * @param array(string=>string) $arguments
     * @return array(string=>string)
     */
    protected function withTransaction(array $arguments)
    {
        if (!$this->inTransaction()) {
            return $arguments;
        }
        $arguments['transaction-id'] = $this->runningTransaction;
        return $arguments;
    }

    /**
     * Starts a new transaction.
     */
    protected function beginTransaction()
    {
        $this->runningTransaction = $this->apiClient->beginTransaction();
    }

    /**
     * Commits the running transaction.
     */
    protected function commit()
    {
        $this->apiClient->commitTransaction($this->withTransaction(array()));
        $this->runningTransaction = null;
    }

    /**
     * Performs a running for the current transaction.
     */
    protected function rollback()
    {
        $this->apiClient->rollbackTransaction($this->withTransaction(array()));
        $this->runningTransaction = null;
    }

    /**
     * Checks if the client is currently in a transaction.
     *
     * @return boolean
     */
    protected function inTransaction()
    {
        return $this->runningTransaction !== null;
    }

}

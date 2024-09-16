<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
/**
 * Uses the low-level API client to provide a more advanced interface
 * that is used to read and manipulate data in a Stardog database.
 *
 * @author   Simeon Ackermann <amseon@web.de>
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_ApiClient
{
    /**
     * Identifiers for the different import formats.
     */
    const FORMAT_RDF_XML  = 'application/rdf+xml';
    const FORMAT_TURTLE   = 'text/turtle';
    const FORMAT_NTRIPLES = 'text/plain';
    const FORMAT_TRIG     = 'application/x-trig';
    const FORMAT_TRIX     = 'application/trix';
    const FORMAT_NQUADS   = 'text/x-nquads';
    const FORMAT_JSON_LD  = 'application/ld+json';

    /**
     * ID of the running transaction or null if no transaction is active.
     *
     * @var string|null
     */
    protected $_runningTransaction = null;

    /**
     * IDs of transactions that have been opened, but not committed or
     * rolled back yet.
     *
     * @var array(string)
     */
    protected $_pendingTransactions = array();

    /**
     * The name of the database that is managed by this setup.
     *
     * @var string
     */
    protected $_database = null;

    /**
     * The base url to stardog
     *
     * @var string
     */
    protected $_baseUrl = null;

    /**
     * The adapter options
     *
     * @var array
     */
    protected $_adapterOptions = array();

    /**
     * Creates a data access client that uses the provided API client.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     * @param array $adapterOptions
     */
    public function __construct(array $adapterOptions = array())
    {
        $this->init($adapterOptions);

        register_shutdown_function(array($this, 'rollbackPendingTransactions'));
    }

    /**
     * Initial connection to Stardog with params from config
     *
     * @param array $options
     */
    public function init(array $options = array())
    {
        if ( ! isset($options['base_url']) ) {
            throw new Erfurt_Store_Adapter_Exception('Your config.ini lacks a store.stardog.base_url parameter.');
        }
        $this->_baseUrl .= ( substr($options['base_url'], -1) == "/" ) ?
            $options['base_url'] : $options['base_url'] . "/";

        if ( ! isset($options['database']) ) {
            throw new Erfurt_Store_Adapter_Exception('Your config.ini lacks a store.stardog.database parameter.');
        }
        $this->_database = $options['database'];
        $this->_adapterOptions = $options;
    }

    /**
     * Returns a list of existing databases
     *
     * @return array
     */
    public function getDatabases()
    {
        $result = $this->httpRequest(
            'admin/databases',
            'GET',
            'accept: application/json'
        )->getBody();

        return json_decode($result, true)['databases'];
    }

    /**
     * Creates an empty database with the provided name.
     *
     * @param string $database
     */
    public function createDatabase($database)
    {
        $boundary = 'b' . md5(uniqid('', true));
        $definition = array(
            'dbname'  => $database,
            'options' => new stdClass(),
            'files'   => array()
        );
        $definitionAsJson = json_encode($definition);

        $body = "--$boundary\r\n"
              . "Content-Disposition: form-data; name=\"definition\"\"\r\n"
              . "Content-Type: application/json\r\n"
              . "\r\n"
              . "$definitionAsJson\r\n"
              . "--$boundary--\r\n";

        return $this->httpRequest(
            'admin/databases',
            'POST',
            'Content-Type: multipart/form-data; boundary=' . $boundary,
            null,
            null,
            $body
        )->getBody();
    }

    /**
     * Deletes the provided databse
     *
     * @param string $database
     */
    public function dropMyDatabase($database)
    {
        return $this->httpRequest(
            'admin/databases/' . $database,
            'DELETE',
            'accept: application/json'
        )->getBody();
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
        $response = $this->httpRequest(
            $this->_database . '/query',
            'POST',
            'accept: application/sparql-results+json',
            null,
            array('query' => $sparqlQuery)
        );

        if ( empty($response->getBody()) ) {
            $result = 'OK' === $response->getMessage() ? true : false;
        } else {
            $result = json_decode($response->getBody(), true);

            if ( isset($result['boolean']) ) {
                $result = (boolean)$result['boolean'];
            }
        }
        return $result;
    }

    /**
     * Imports the provided data.
     *
     * The provided triple data must be a string that fulfills the requirements
     * of the given format.
     * Optionally an import graph can be provided. If no graph is given, then the
     * data will be imported into the default graph.
     * Please note that formats that rely on quads should not provide a graph.
     *
     * Example:
     *
     *     $data = '<http://example.org/subject> <http://example.org/predicate> <http://example.org/object> .';
     *     $client->import(
     *         $data,
     *         'http://example.org/target-graph',
     *         Erfurt_Store_Adapter_Stardog_DataAccessClient::FORMAT_NTRIPLES
     *     );
     *
     * @param string $data
     * @param string|null $graph
     * @param string $format
     */
    public function import($data, $graph = null, $format = self::FORMAT_TURTLE)
    {
        $arguments = array(
            'triples'     => $data,
            'inputFormat' => $format
        );
        if ($graph !== null) {
            $arguments['graph-uri'] = $graph;
        }
        /* The add operation must be wrapped into a transaction.
        transactional() is used to start a transaction if that did not already happen.
        The transaction ID is passed by reference as it will only be available when
        the execution of transactional() starts. */
        $transaction = &$this->_runningTransaction;

        $this->transactional(
            function () use (&$transaction, $arguments) {
                $arguments['transaction-id'] = $transaction;
                $this->mutativeOperation('/add', $arguments);
            }
        );
    }

    /**
     * Removes the given set of triples.
     *
     * This method works in the same way as import().
     *
     * Example:
     *
     *     $data = '<http://example.org/subject> <http://example.org/predicate> <http://example.org/object> .';
     *     $client->delete(
     *         $data,
     *         'http://example.org/affected-graph'
     *         Erfurt_Store_Adapter_Stardog_DataAccessClient::FORMAT_NTRIPLES,
     *     );
     *
     * @param string $data
     * @param string|null $graph
     * @param string $format
     */
    public function remove($data, $graph = NULL, $format = self::FORMAT_TURTLE)
    {
        $arguments = array(
            'triples'     => $data,
            'inputFormat' => $format
        );
        if ($graph !== null) {
            $arguments['graph-uri'] = $graph;
        }
        // Passes the triples that must be deleted and manages the transaction that
        // is required for the remove() call (analog to import()).
        $transaction = &$this->_runningTransaction;

        $this->transactional(
            function () use (&$transaction, $arguments) {
                $arguments['transaction-id'] = $transaction;
                $this->mutativeOperation('/remove', $arguments);
            }
        );
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
    public function transactional(callable $callback)
    {
        if ($this->inTransaction()) {
            /* A transaction is already active, therefore, this execution of transactional()
            is not responsible for transaction management. */
            call_user_func($callback, $this);
            return;
        }
        $this->beginTransaction();
        try {
            call_user_func($callback, $this);
            $this->commit();
        } catch (Exception $e) {
            try {
                $this->rollback();
            } catch (\Exception $rollbackException) {
                $message = 'Transaction rollback failed: ' . PHP_EOL . $rollbackException;
                throw new RuntimeException($message, Erfurt_Exception::DEFAULT_ERROR, $e);
            }
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
        $arguments['transaction-id'] = $this->_runningTransaction;
        return $arguments;
    }

    /**
     * Starts a new transaction.
     *
     * @return string $id
     */
    protected function beginTransaction()
    {
        $id = $this->databaseOperation('POST', '/transaction/begin');
        $this->_runningTransaction = (string) $id;
        $this->_pendingTransactions[] = (string) $id;
        return $id;
    }

    /**
     * Commits the running transaction.
     */
    protected function commit()
    {
        $transactionId = $this->withTransaction(array())['transaction-id'];
        $this->transactionalOperation($transactionId, '/transaction/commit/');
        $this->removePendingTransaction($transactionId);
        $this->_runningTransaction = null;
    }

    /**
     * Performs a running for the current transaction.
     */
    protected function rollback()
    {
        $id = $this->withTransaction(array())['transaction-id'];
        $this->transactionalOperation($id, '/transaction/rollback/');
        if (in_array($id, $this->_pendingTransactions)) {
            unset($this->_pendingTransactions[array_search($id, $this->_pendingTransactions)]);
        }
        $this->_runningTransaction = null;
    }

    /**
     * Checks if the client is currently in a transaction.
     *
     * @return boolean
     */
    protected function inTransaction()
    {
        return $this->_runningTransaction !== null;
    }

    /**
     * Removes the provided ID from the list of pending transactions.
     *
     * @param string $id
     */
    protected function removePendingTransaction($id)
    {
        if (in_array($id, $this->_pendingTransactions)) {
            unset($this->_pendingTransactions[array_search($id, $this->_pendingTransactions)]);
        }
    }

    /**
     * Rolls back any transaction that is still pending.
     */
    public function rollbackPendingTransactions()
    {
        if (count($this->_pendingTransactions) === 0) {
            return;
        }
        foreach ($this->_pendingTransactions as $id) {
            $this->transactionalOperation($id, '/transaction/rollback/');
        }
        $this->_pendingTransactions = array();
    }

    /**
     * Operation against the database
     *
     * @param string $httpMethod (POST|GET)
     * @param string $uri
     * @return string Transaction Id
     */
    protected function databaseOperation($httpMethod, $uri)
    {
        return $this->httpRequest(
            $this->_database . $uri,
            $httpMethod,
            'accept: text/plain'
        )->getBody();
    }

    /**
     * Operation that requires transaction
     *
     * @param string $transactionId
     * @param string $uri
     * @return string|array
     */
    protected function transactionalOperation($transactionId, $uri)
    {
        return $this->httpRequest(
            $this->_database . $uri . $transactionId,
            'POST'
        )->getBody();
    }

    /**
     * Operation that uses a set of triples to change the database
     *
     * @param string $uri
     * @param array(string->value) $arguments
     * @throws Erfurt_Store_Adapter_Exception if no valid triple set was passed
     * @return string|array|boolean Result set, depends on request
     */
    protected function mutativeOperation(
        $uri, array $arguments = array('triples' => '', 'graph-uri' => NULL, 'inputFormat' => FORMAT_TURTLE)
    )
    {
        return $this->httpRequest(
            $this->_database . '/' . $arguments['transaction-id'] . $uri,
            'POST',
            'Content-Type: ' . $arguments['inputFormat'],
            array('graph-uri' => $arguments['graph-uri']),
            null,
            $arguments['triples']
        )->getBody();
    }

    /**
     * Get a new Zend http client with authentification
     *
     * @return Zend_Http_Client
     */
    protected function getClient()
    {
        $client = new Zend_Http_Client();
        if (isset($this->_adapterOptions['username']) && isset($this->_adapterOptions['password'])) {
            $client->setAuth($this->_adapterOptions['username'], $this->_adapterOptions['password']);
        }
        return $client;
    }

    /**
     * Do a http request
     *
     * @param string $uri Uri ti request without base uri
     * @param string $httpMethod Httpo Method (POST, GET, DELETE, ....)
     * @param string $headers Http request headers
     * @param array $paramGet Array with post parameters (name => value)
     * @param array $paramPost Array with get parameters (name => value)
     * @param string $rawData Request body data
     * @return Zend_Http_Response
     */
    protected function httpRequest(
        $uri = '', $httpMethod = 'POST', $headers = '', $paramGet = array(), $paramPost = array(), $rawData = ''
    )
    {
        $client = $this->getClient();
        $client->setUri($this->_baseUrl . $uri);
        if ( ! empty($headers) ) {
            $client->setHeaders($headers);
        }
        if ( ! empty($paramGet) ) {
            $client->setParameterGet($paramGet);
        }
        if ( ! empty($paramPost) ) {
            $client->setParameterPost($paramPost);
        }
        if ( ! empty($rawData) ) {
            $client->setRawData($rawData);
        }
        $response = $client->request($httpMethod);

        if ( $response->isError() ) {
            throw new Erfurt_Store_Adapter_Exception(
                sprintf("HTTP Request Error: %s", $response->getMessage())
            );
        }
        return $response;
    }
}

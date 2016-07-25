<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Exception\RequestException;

/**
 * Uses the low-level API client to provide a more advanced interface
 * that is used to read and manipulate data in a Stardog database.
 *
 * @author   Simeon Ackermann <amseon@web.de>
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_ApiClient extends Client
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
     * The low-level client that is used to interact with the triple store.
     *
     * @var GuzzleHttp/Client
     */
    protected $_apiClient = null;

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
     * Creates a data access client that uses the provided API client.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     * @param array $adapterOptions
     */
    public function __construct(array $adapterOptions = array())
    {
        $this->_apiClient = $this->init($adapterOptions);

        register_shutdown_function(array($this, 'rollbackPendingTransactions'));
    }

    /**
     * Initial connection to Stardog with params from config
     *
     * @param array $options
     * @return GuzzleHttp/Client
     */
    public function init(array $options = array())
    {
        $client = $this->_apiClient;
        if ( ! $client ) {

            if ( ! isset($options['base_url']) ) {
                throw new Erfurt_Store_Adapter_Exception('Your config.ini lacks a store.stardog.base_url parameter.');
            }

            if ( ! isset($options['database']) ) {
                throw new Erfurt_Store_Adapter_Exception('Your config.ini lacks a store.stardog.database parameter.');
            } else {
                $this->_database = $options['database'];
            }

            if (isset($options['username']) && isset($options['password'])) {
                $options['defaults'] = [ 'auth' => [ (string)$options['username'], (string)$options['password'] ] ];
            }

            $client = new Client($options);
        }
        return $client;
    }

    /**
     * Returns a list of exiisting databases
     *
     * @return array
     */
    public function getDatabases()
    {
        $requestOptions = [
            'headers' => [ 'accept' => 'application/json' ]
        ];

        $res = $this->_apiClient->get('/admin/databases', $requestOptions);
        $res = json_decode($res->getBody(), true);
        return $res['databases'];
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

        $requestOptions = [
            'body' => $body,
            'headers' => [ 'Content-Type' => 'multipart/form-data; boundary=' . $boundary ]
        ];

        $this->_apiClient->post('/admin/databases', $requestOptions);
    }

    /**
     * Deletes the provided databse
     *
     * @param string $database
     */
    public function dropMyDatabase($database)
    {
        $requestOptions = [
            'headers' => [ 'accept' => 'application/json' ]
        ];
        $this->_apiClient->delete('/admin/databases/' . $database, $requestOptions);
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
        $requestOptions = [
            'body' => [ 'query' => $sparqlQuery ],
            'headers' => [ 'accept' => 'application/sparql-results+json' ]
        ];

        try {
            $res = $this->_apiClient->post($this->_database . '/query', $requestOptions);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $message = sprintf('SPARQL Error: %s with query: %s', $e->getResponse(), $sparqlQuery);
            } else {
                $message = sprintf('SPARQL Error with query: %s', $sparqlQuery);
            }
            throw new Erfurt_Store_Adapter_Exception($message);
        } catch (Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('SQL Error with query:' . $sparqlQuery);
        }

        if ( empty($res->getBody()) ) {
            return 'OK' === $res->getReasonPhrase() ? true : false;
        } else {
            $res = json_decode($res->getBody(), true);

            if ( isset($res['boolean']) ) {
                return (boolean)$res['boolean'];
            }

            return $res;
        }
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
        $apiClient   = $this->_apiClient;
        $transaction = &$this->_runningTransaction;

        $this->transactional(
            function () use ($apiClient, &$transaction, $arguments) {
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
        $apiClient   = $this->_apiClient;
        $transaction = &$this->_runningTransaction;

        $this->transactional(
            function () use ($apiClient, &$transaction, $arguments) {
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
                throw new RuntimeException($message, 0, $e);
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
        $request = $this->_apiClient->createRequest($httpMethod, $this->_database . $uri);
        $response = $this->_apiClient->send($request);
        return $response->getBody();
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
        $res = $this->_apiClient->post($this->_database . $uri . $transactionId);
        return $res->getBody();
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
        $uri = $this->_database . '/' . $arguments['transaction-id'] . $uri;

        $requestOptions = [
            'body' => $arguments['triples'],
            'query' => ['graph-uri' => $arguments['graph-uri']],
            'headers' => [ 'Content-Type' => $arguments['inputFormat'] ]
        ];

        try {
            $res = $this->_apiClient->post($uri, $requestOptions);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $message = sprintf("SPARQL Error: \n %s with triples: %s", $e->getResponse(), $arguments['triples']);
            } else {
                $message = sprintf('SPARQL Error with triples: %s', $arguments['triples']);
            }
            throw new Erfurt_Store_Adapter_Exception($message);
        } catch (Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('SQL Error with triples:' . $arguments['triples']);
        }

        return $res->getBody();
    }
}

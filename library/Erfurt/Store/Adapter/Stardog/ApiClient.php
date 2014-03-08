<?php

use Guzzle\Batch\BatchBuilder;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Http\RedirectPlugin;
use Guzzle\Log\MessageFormatter;
use Guzzle\Log\Zf1LogAdapter;
use Guzzle\Plugin\Async\AsyncPlugin;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * HTTP client for the Stardog API.
 *
 * This client provides the low-level API to interact with the Stardog triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 * @method void clear(array) Clear a specific graph or the whole database. Requires a transaction ID.
 * @method void add(array) Adds a set of triples. Requires a transaction ID.
 * @method void remove(array) Removes a set of triples. Requires a transaction ID.
 */
class Erfurt_Store_Adapter_Stardog_ApiClient extends Client
{

    /**
     * IDs of transactions that have been opened, but not committed or
     * rolled back yet.
     *
     * @var array(string)
     */
    protected $pendingTransactions = array();

    /**
     * Creates a new API client instance.
     *
     * @param array|Collection $config Configuration data
     * @return Erfurt_Store_Adapter_Stardog_ApiClient
     */
    public static function factory($config = array())
    {
        $client = parent::factory($config);
        $client->setDescription(ServiceDescription::factory(__DIR__ . '/Resources/StardogServiceDescription.json'));
        if (isset($config['username']) && isset($config['password'])) {
            $client->setDefaultOption('auth', array($config['username'], $config['password'], 'Any'));
        }
        $client->addSubscriber(new Erfurt_Store_Adapter_Stardog_ExceptionListener());
        if (isset($config['log']) && $config['log'] !== null) {
            $adapter = new Zf1LogAdapter(
                new \Zend_Log(new \Zend_Log_Writer_Stream($config['log']))
            );
            $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
            $client->addSubscriber($logPlugin);
        }
        return $client;
    }

    /**
     * Creates the client.
     *
     * @param string $baseUrl Base URL of the web service
     * @param array|Collection $config  Configuration settings
     */
    public function __construct($baseUrl = '', $config = null)
    {
        parent::__construct($baseUrl, $config);
        // Ensure that open transactions are closed once the script finished.
        // This is important, as transaction leftovers lead to decreased performance.
        // A shutdown function is used as execution in the destructor lead to
        // unpredictable PHP crashes.
        register_shutdown_function(array($this, 'rollbackPendingTransactions'));
    }

    /**
     * Returns the number of triples in the database.
     *
     * @return integer
     */
    public function size()
    {
        $command = $this->getCommand('size');
        $command->execute();
        $response = $command->getResult();
        return (int)$response->getBody(true);
    }

    /**
     * Executes a SPARQL query of any type.
     *
     * Returns the result, which depends on the query type (i.e. ASK or INSERT queries
     * return XML with a boolean flag, SELECT queries return an extended result set
     * as array).
     *
     * @param array(string=>string) $arguments
     * @return array|SimpleXMLElement
     */
    public function query(array $arguments)
    {
        $command = $this->getCommand('query', $arguments);
        $command->execute();
        return $command->getResult();
    }

    /**
     * Returns an execution plan for a SPARQL query.
     *
     * The following argument keys are supported:
     *
     * - query (string): The SPARQL query.
     *
     * @param array(string=>mixed) $arguments
     * @return string
     */
    public function explain(array $arguments)
    {
        $command = $this->getCommand('explain', $arguments);
        $command->execute();
        $response = $command->getResult();
        return $response->getBody(true);
    }

    /**
     * Starts a transaction.
     *
     * The returned transaction ID must be passed to operations that
     * shall be executed in the transaction.
     *
     * @return string The transaction ID.
     */
    public function beginTransaction()
    {
        $command = $this->getCommand('beginTransaction');
        $command->execute();
        $response = $command->getResult();
        $id = $response->getBody(true);
        $this->pendingTransactions[] = $id;
        return $id;
    }

    /**
     * Commits the transaction with the provided ID.
     *
     * @param array(string=>string) $arguments
     */
    public function commitTransaction(array $arguments)
    {
        $this->getCommand('commitTransaction', $arguments)->execute();
        $this->removePendingTransaction($arguments['transaction-id']);
    }

    /**
     *  Reverts changes of the transaction with the provided ID.
     *
     * @param array(string=>string) $arguments
     */
    public function rollbackTransaction(array $arguments)
    {
        $this->getCommand('rollbackTransaction', $arguments)->execute();
        $this->removePendingTransaction($arguments['transaction-id']);
    }

    /**
     * Removes the provided ID from the list of pending transactions.
     *
     * @param string $id
     */
    protected function removePendingTransaction($id)
    {
        if (in_array($id, $this->pendingTransactions)) {
            unset($this->pendingTransactions[array_search($id, $this->pendingTransactions)]);
        }
    }

    /**
     * Rolls back any transaction that is still pending.
     */
    public function rollbackPendingTransactions()
    {
        if (count($this->pendingTransactions) === 0) {
            return;
        }
        $this->addSubscriber(new AsyncPlugin());
        $batch = BatchBuilder::factory()->transferCommands(5)
                                        ->autoFlushAt(5)
                                        ->bufferExceptions()
                                        ->build();
        foreach ($this->pendingTransactions as $id) {
            /* @var $id string */
            $batch->add($this->getCommand('rollbackTransaction', array('transaction-id' => $id)));
        }
        $batch->flush();
        $this->pendingTransactions = array();
    }

}

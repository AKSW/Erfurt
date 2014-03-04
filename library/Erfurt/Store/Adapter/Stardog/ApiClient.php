<?php

use Guzzle\Common\Collection;
use Guzzle\Log\MessageFormatter;
use Guzzle\Log\Zf1LogAdapter;
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
 * @method array query(array) Executes a SPARQL query.
 * @method void commitTransaction(array) Commits the transaction with the provided ID.
 * @method void rollbackTransaction(array) Reverts changes of the transaction with the provided ID.
 * @method void clear(array) Clear a specific graph or the whole database. Requires a transaction ID.
 * @method void add(array) Adds a set of triples. Requires a transaction ID.
 * @method void remove(array) Removes a set of triples. Requires a transaction ID.
 * @method void optimizeDatabase() Optimizes the database.
 */
class Erfurt_Store_Adapter_Stardog_ApiClient extends Client
{

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
     * Returns the number of triples in the database.
     *
     * @return integer
     */
    public function size()
    {
        /* @var $response \Guzzle\Http\Message\Response */
        $response = parent::size();
        return (int)$response->getBody(true);
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
        /* @var $response \Guzzle\Http\Message\Response */
        $response = parent::explain($arguments);
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
        /* @var $response \Guzzle\Http\Message\Response */
        $response = parent::beginTransaction();
        return $response->getBody(true);
    }

}

<?php

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * HTTP client for the Stardog API.
 *
 * This client provides the low-level API to interact with the Stardog triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 * @method array query(array)
 * @method void commitTransaction(array) Commits the transaction with the provided ID.
 * @method void rollbackTransaction(array) Reverts changes of the transaction with the provided ID.
 * @method void clear(array) Clear a specific graph or the whole database. Requires a transaction ID.
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

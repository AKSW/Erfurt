<?php

use Guzzle\Common\Collection;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Log\MessageFormatter;
use Guzzle\Log\Zf1LogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * API client for the Neo4J SPARQL plugin.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 13.03.14
 * @method void insert(array) Inserts a quad.
 */
class Erfurt_Store_Adapter_Neo4J_SparqlApiClient extends Client
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
        $client->setDescription(ServiceDescription::factory(__DIR__ . '/Resources/SparqlPluginServiceDescription.json'));
        $client->addSubscriber(new Erfurt_Store_Adapter_Neo4J_ExceptionListener());
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
     * Executes a SPARQL query.
     *
     * @param string $sparqlQuery
     * @return array(array(string=>string))
     * @throws \Guzzle\Http\Exception\BadResponseException If an error occurs.
     */
    public function query($sparqlQuery)
    {
        $command = $this->getCommand('query', array('query' => $sparqlQuery));
        $command->execute();
        $result = $command->getResult();
        if (!is_array($result)) {
            $message = 'An error occurred while executing the following query: ' . PHP_EOL
                     . '%s' . PHP_EOL
                     . 'Error: ' . PHP_EOL
                     . '%s';
            $message = sprintf($message, $sparqlQuery, $result);
            $exception = new BadResponseException($message);
            $exception->setRequest($command->getRequest());
            $exception->setResponse($command->getResponse());
            throw $exception;
        }
        return $result;
    }

}

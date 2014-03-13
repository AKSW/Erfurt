<?php

use Guzzle\Common\Collection;
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
 * @method array query(array) Executes a SPARQL query.
 */
class Erfurt_Store_Adapter_Neo4J_ApiClient extends Client
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

}

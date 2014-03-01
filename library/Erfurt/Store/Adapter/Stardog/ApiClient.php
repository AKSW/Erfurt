<?php

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * HTTP client for the Stardog API.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
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

}

<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper class that is used to set up the environment for Stardog integration tests.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_StardogTestHelper extends Erfurt_AbstractTestHelper
    implements \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{

    /**
     * The Stardog SPARQL connector or null if it was not initialized yet.
     *
     * @var \Erfurt_Store_Adapter_Stardog_StardogSparqlConnector|null
     */
    protected $sparqlConnector = null;

    /**
     * The Stardog API client or null if it was not initialized yet.
     *
     * @var \Erfurt_Store_Adapter_Stardog_ApiClient|null
     */
    protected $apiClient = null;

    /**
     * The service container or null if it was not initialized yet.
     *
     * @var ContainerInterface|null
     */
    protected $container = null;

    /**
     * Flag that indicates if the database was already cleared.
     *
     * @var boolean
     */
    protected $databaseCleared = false;

    /**
     * Returns the SPARQL connector.
     *
     * @return \Erfurt_Store_Adapter_Stardog_StardogSparqlConnector
     */
    public function getSparqlConnector()
    {
        if ($this->sparqlConnector === null) {
            $this->clearDatabase();
            $connector = $this->getContainer()->get('stardog.sparql_connector');
            $expectedType = 'Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface';
            PHPUnit_Framework_Assert::assertInstanceOf($expectedType, $connector);
            $this->sparqlConnector = $connector;
            $this->addCleanUpTask(array($this, 'unsetSparqlConnector'));
        }
        return $this->sparqlConnector;
    }

    /**
     * Returns the data access client.
     *
     * @return \Erfurt_Store_Adapter_Stardog_DataAccessClient
     */
    public function getDataAccessClient()
    {
        $client = $this->getContainer()->get('stardog.data_access_client');
        PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Stardog_DataAccessClient', $client);
        $this->clearDatabase();
        return $client;
    }

    /**
     * Returns the Stardog API client instance.
     *
     * @return Erfurt_Store_Adapter_Stardog_ApiClient
     */
    public function getApiClient()
    {
        if ($this->apiClient === null) {
            $container = $this->getContainer();
            $client    = $container->get('stardog.api_client');
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Stardog_ApiClient', $client);
            $this->apiClient = $client;
            $this->addCleanUpTask(array($this, 'unsetApiClient'));
        }
        return $this->apiClient;
    }

    /**
     * Returns the service container that wires the different
     * components for the Stardog connector.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        if ($this->container === null) {
            $config = $this->getConfig();
            $config['service'] = 'service_container';
            $this->container = \Erfurt_Store_Adapter_Container::createFromOptions($config);
            $this->addCleanUpTask(array($this, 'unsetContainer'));
        }
        return $this->container;
    }

    /**
     * Removes all triples from the database.
     */
    protected function clearDatabase()
    {
        if ($this->databaseCleared) {
            // Database was already cleared.
            return;
        }
        $client = $this->getApiClient();
        $id = $client->beginTransaction();
        $this->getApiClient()->clear(array('transaction-id' => $id));
        $client->commitTransaction(array('transaction-id' => $id));
        $this->databaseCleared = true;
    }

    /**
     * Destroys the created SPARQL connector.
     */
    protected function unsetSparqlConnector()
    {
        $this->sparqlConnector = null;
    }

    /**
     * Destroys the created API client.
     */
    protected function unsetApiClient()
    {
        $this->apiClient = null;
    }

    /**
     * Destroys the created service container.
     */
    protected function unsetContainer()
    {
        $this->container = null;
    }

}

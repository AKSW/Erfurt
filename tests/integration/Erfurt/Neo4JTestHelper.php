<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper class that is used to set up the environment for Neo4J integration tests.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 13.03.14
 */
class Erfurt_Neo4JTestHelper extends Erfurt_AbstractTestHelper
    implements \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{

    /**
     * The created SPARQL connector.
     *
     * @var \Erfurt_Store_Adapter_Neo4J_Neo4JSparqlConnector|null
     */
    protected $sparqlConnector = null;

    /**
     * The store management client.
     *
     * @var Erfurt_Store_Adapter_Neo4J_StoreManagementClient
     */
    protected $managementClient = null;

    /**
     * The SPARQL plugin API client instance that has been created.
     *
     * @var Erfurt_Store_Adapter_Neo4J_SparqlApiClient|null
     */
    protected $sparqlApiClient = null;

    /**
     * The API client instance that has been created.
     *
     * @var Erfurt_Store_Adapter_Neo4J_ApiClient|null
     */
    protected $apiClient = null;

    /**
     * The service container or null if it was not initialized yet.
     *
     * @var ContainerInterface|null
     */
    protected $container = null;

    /**
     * Returns a SPARQL connector, which is used in the benchmark and that operates
     * on a fresh (= empty) triple store database.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     * @throws BadMethodCallException Currently not implemented.
     */
    public function getSparqlConnector()
    {
        if ($this->sparqlConnector === null) {
            $container = $this->getContainer();
            $connector = $container->get('neo4j.sparql_connector');
            PHPUnit_Framework_Assert::assertInstanceOf(
                'Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface',
                $connector
            );
            $this->getManagementClient()->clear();
            $this->sparqlConnector = $connector;
            $this->addCleanUpTask(array($this, 'unsetSparqlConnector'));
        }
        return $this->sparqlConnector;
    }

    /**
     * Returns the store management client.
     *
     * @return Erfurt_Store_Adapter_Neo4J_StoreManagementClient
     */
    public function getManagementClient()
    {
        if ($this->managementClient === null) {
            $container = $this->getContainer();
            $client    = $container->get('neo4j.client.store_management');
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Neo4J_StoreManagementClient', $client);
            $this->managementClient = $client;
            $this->addCleanUpTask(array($this, 'unsetManagementClient'));
        }
        return $this->managementClient;
    }

    /**
     * Returns the Neo4J API client instance.
     *
     * @return Erfurt_Store_Adapter_Neo4J_SparqlApiClient
     */
    public function getSparqlApiClient()
    {
        if ($this->sparqlApiClient === null) {
            $container = $this->getContainer();
            $client    = $container->get('neo4j.client.sparql_api');
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Neo4J_SparqlApiClient', $client);
            $this->sparqlApiClient = $client;
            $this->addCleanUpTask(array($this, 'unsetSparqlApiClient'));
        }
        return $this->sparqlApiClient;
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
            $client    = $container->get('neo4j.client.api');
            PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Neo4J_ApiClient', $client);
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
     * Destroys the created SPARQL connector.
     */
    protected function unsetSparqlConnector()
    {
        $this->sparqlConnector = null;
    }

    /**
     * Destroys the created management client.
     */
    protected function unsetManagementClient()
    {
        $this->managementClient = null;
    }

    /**
     * Destroys the created API client.
     */
    protected function unsetSparqlApiClient()
    {
        $this->sparqlApiClient = null;
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

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
     * The API client instance that has been created.
     *
     * @var Erfurt_Store_Adapter_Neo4J_SparqlApiClient|null
     */
    protected $sparqlApiClient = null;

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
        throw new BadMethodCallException('Not implemented yet.');
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
            $this->addCleanUpTask(array($this, 'unsetApiClient'));
        }
        return $this->sparqlApiClient;
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
     * Destroys the created API client.
     */
    protected function unsetApiClient()
    {
        $this->sparqlApiClient = null;
    }

    /**
     * Destroys the created service container.
     */
    protected function unsetContainer()
    {
        $this->container = null;
    }

}

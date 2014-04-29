<?php

/**
 * Helper class that is used to prepare the MySQL adapter for benchmarking.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 28.04.14
 */
class Erfurt_MySqlTestHelper extends Erfurt_AbstractTestHelper
    implements \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{

    /**
     * Connector that uses MySQL as backend.
     *
     * @var \Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter|null
     */
    protected $sparqlConnector = null;

    /**
     * Returns a SPARQL connector, which is used in the benchmark and that operates
     * on a fresh (= empty) triple store database.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    public function getSparqlConnector()
    {
        if ($this->sparqlConnector === null) {
            $adapterConfig = $this->getConfig();
            $globalFakeConfig = new Zend_Config(array(
                'store' => array(
                    'zenddb'  => $adapterConfig,
                    'backend' => 'zenddb'
                ),
                'cache' => array(
                    'backend' => array(
                        'file' => array(
                            'cache_dir' => __DIR__ . '/../cache'
                        )
                    )
                )
            ));
            Erfurt_App::getInstance()->loadConfig($globalFakeConfig);
            $adapter = new Erfurt_Store_Adapter_EfZendDb($adapterConfig);
            // Clear the database.
            foreach (array_keys($adapter->getAvailableModels()) as $graph) {
                $adapter->deleteModel($graph);
            }
            $this->sparqlConnector = new Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter($adapter, 50);
            $this->addCleanUpTask(array($this, 'unsetSparqlConnector'));
        }
        return $this->sparqlConnector;
    }

    /**
     * Destroys the used SPARQL connector.
     */
    protected function unsetSparqlConnector()
    {
        $this->sparqlConnector = null;
    }

}

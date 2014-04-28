<?php

/**
 * Helper class that is used to prepare Virtuoso for benchmarking.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 28.04.14
 */
class Erfurt_VirtuosoTestHelper extends Erfurt_AbstractTestHelper
    implements \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{

    /**
     * Connector that uses Virtuoso as backend.
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
            $adapter = new Erfurt_Store_Adapter_Virtuoso($this->getConfig());
            // Clear the database.
            foreach ($adapter->getAvailableModels() as $graph) {
                $adapter->deleteModel($graph);
            }
            $this->sparqlConnector = new Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter($adapter);
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

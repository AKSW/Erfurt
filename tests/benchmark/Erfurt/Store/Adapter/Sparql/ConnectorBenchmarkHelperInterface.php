<?php

/**
 * Interface that must be implemented by classes that are used to set up
 * connector benchmarks.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
interface Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{
    /**
     * Returns a SPARQL connector, which is used in the benchmark and that operates
     * on a fresh (= empty) triple store database.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    public function getSparqlConnector();

    /**
     * Performs clean up tasks if necessary.
     */
    public function cleanUp();

}
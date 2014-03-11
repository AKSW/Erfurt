<?php

/**
 * Wraps a connector and logs all queries whose execution time reaches a provided threshold in milliseconds.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.03.14
 */
class Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecorator
    extends Erfurt_Store_Adapter_Sparql_Connector_AbstractSparqlConnectorDecorator
{

    /**
     * Logs all queries that are executes slowly by the provided connector.
     *
     * @param Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     * @param Zend_Log $log
     * @param integer $thresholdInMs
     */
    public function __construct(
        Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector,
        Zend_Log $log,
        $thresholdInMs
    ) {
        parent::__construct($connector);
    }

    /**
     * Executes the provided SPARQL query and returns its results.
     *
     * Additionally, slow queries are logged.
     *
     * @param string $sparqlQuery
     * @return array|boolean
     */
    public function query($sparqlQuery)
    {
        $result = parent::query($sparqlQuery);
        return $result;
    }

}

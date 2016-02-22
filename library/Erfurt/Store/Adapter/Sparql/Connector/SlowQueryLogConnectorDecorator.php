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
     * The log instance that is used.
     *
     * @var Zend_Log
     */
    protected $log = null;

    /**
     * The threshold in seconds, which must be reached before a query
     * is considered "slow".
     *
     * @var double
     */
    protected $thresholdInS = null;

    /**
     * Unique identifier that can be used to determine which messages have
     * been logged by this instance.
     *
     * @var string
     */
    protected $identifier = null;

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
        $this->log          = $log;
        $this->thresholdInS = $thresholdInMs / 1000.0;
        $this->identifier   = uniqid('ID', true);
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
        $start       = microtime(true);
        $result      = parent::query($sparqlQuery);
        $durationInS = microtime(true) - $start;
        if ($durationInS >= $this->thresholdInS) {
            $this->logQuery($sparqlQuery, $durationInS);
        }
        return $result;
    }

    /**
     * Logs the provided query.
     *
     * @param string $query
     * @param double $durationInS
     */
    protected function logQuery($query, $durationInS)
    {
        $message = '[Request %s] The following query took %1.2F seconds and exceeded the threshold of %01.2F seconds: '
                 . PHP_EOL . '%s';
        $message = sprintf($message, $this->identifier, $durationInS, $this->thresholdInS, $query);
        $this->log->log($message, Zend_Log::INFO, array(
            'query'              => $query,
            'durationInSeconds'  => $durationInS,
            'thresholdInSeconds' => $this->thresholdInS,
            'logIdentifier'      => $this->identifier
        ));
    }

}

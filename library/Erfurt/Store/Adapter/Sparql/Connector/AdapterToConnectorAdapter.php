<?php

/**
 * Adapter implementation that allows the usage of a Store adapter (\Erfurt_Store_Adapter_Interface)
 * as a Connector (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 27.04.14
 */
class Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter
    implements Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
{

    /**
     * The Store adapter whose functionality is mapped to the
     * Connector interface.
     *
     * @var \Erfurt_Store_Adapter_Interface
     */
    protected $storeAdapter = null;

    /**
     * The buffer that is used to group insert operations.
     *
     * @var Erfurt_Store_Adapter_Sparql_QuadBuffer
     */
    protected $buffer = null;

    /**
     * Creates an adapter for the given Store adapter.
     *
     * @param Erfurt_Store_Adapter_Interface $storeAdapter
     */
    public function __construct(Erfurt_Store_Adapter_Interface $storeAdapter)
    {
        $this->storeAdapter = $storeAdapter;
        $this->buffer       = new Erfurt_Store_Adapter_Sparql_QuadBuffer(array($this, 'persist'));
    }

    /**
     * Adds the provided triple to the data store.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple($graphIri, \Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        $this->buffer->add(Erfurt_Store_Adapter_Sparql_Quad::create($graphIri, $triple));
    }

    /**
     * Executes the provided SPARQL query and returns its results.
     *
     * The results of an ASK query must be returned as boolean.
     *
     * If the query produces a result set, then it must be returned as array
     * in extended format.
     * The extended format each value contains additional information about
     * its type and properties such as the language:
     *
     *     array(
     *         'head' => array(
     *             'vars' => array(
     *                 // Contains the names of all variables that occur in the result set.
     *                 'variable1',
     *                 'variable2'
     *             )
     *         )
     *         'results' => array(
     *             'bindings' => array(
     *                 // Contains one entry for each result set row.
     *                 // Each entry contains the variable name as key and a set
     *                 // of additional information as value:
     *                 array(
     *                     'variable1' => array(
     *                         'value' => 'http://example.org',
     *                         'type'  => 'uri'
     *                     ),
     *                     'variable2' => array(
     *                         'value' => 'Hello world!',
     *                         'type'  => 'literal'
     *                     )
     *                 )
     *             )
     *         )
     *     )
     *
     * @param string $sparqlQuery
     * @return array|boolean
     */
    public function query($sparqlQuery)
    {
        if ($this->isAskQuery($sparqlQuery)) {
            return $this->storeAdapter->sparqlAsk($sparqlQuery);
        }
        $options = array(Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED);
        return $this->storeAdapter->sparqlQuery($sparqlQuery, $options);
    }

    /**
     * Deletes all triples in the given graph that match the provided pattern.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_TriplePattern $pattern
     * @return integer The number of deleted triples.
     */
    public function deleteMatchingTriples($graphIri, Erfurt_Store_Adapter_Sparql_TriplePattern $pattern)
    {
        return $this->storeAdapter->deleteMatchingStatements(
            $graphIri,
            $pattern->getSubject(),
            $pattern->getPredicate(),
            $pattern->getObject()
        );
    }

    /**
     * Accepts a callback function and processes it in batch mode.
     *
     * In batch mode the connector can decide to optimize the execution
     * for example by delaying inserts or wrapping the whole task
     * into a transaction.
     *
     * However, using the batch mode does *not* guarantee transactional
     * behavior.
     *
     * The callback receives the connector itself as argument, which
     * can be used to issue commands:
     *
     *     $connector->batch(function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $batchConnector) {
     *         $batchConnector->addTriple(
     *             'http://example.org',
     *             new \Erfurt_Store_Adapter_Sparql_Triple(
     *                 'http://example.org/subject1',
     *                 'http://example.org/predicate1',
     *                 'http://example.org/object1'
     *             );
     *         );
     *         $batchConnector->addTriple(
     *             'http://example.org',
     *             new \Erfurt_Store_Adapter_Sparql_Triple(
     *                 'http://example.org/subject2',
     *                 'http://example.org/predicate2',
     *                 'http://example.org/object2'
     *             );
     *         );
     *     });
     *
     * Finally, the batch() method returns the result of the provided callback:
     *
     *     // Result contains 42.
     *     $result = $connector->batch(function () {
     *         return 42;
     *     });
     *
     * @param mixed $callback A callback function.
     * @return mixed
     */
    public function batch($callback)
    {
        $this->buffer->setSize(50);
        $result = call_user_func($callback, $this);
        $this->buffer->flush();
        $this->buffer->setSize(1);
        return $result;
    }

    /**
     * Persists the provided quads.
     *
     * This method is only public to be callable by the buffer.
     * A cleaner solution could be to move this to a custom class
     * that deals only with persistence.
     *
     * @param array(Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        if (count($quads) === 0) {
            return;
        }
        if (count($quads) === 1) {
            /* @var $quad Erfurt_Store_Adapter_Sparql_Quad */
            $quad = current($quads);
            $this->storeAdapter->addStatement(
                $quad->getGraph(),
                $quad->getSubject(),
                $quad->getPredicate(),
                $quad->getObject()
            );
            return;
        }
        $statementsByGraph = array();
        foreach ($quads as $quad) {
            /* @var $quad Erfurt_Store_Adapter_Sparql_Quad */
            if (!isset($statementsByGraph[$quad->getGraph()][$quad->getSubject()][$quad->getPredicate()])) {
                $statementsByGraph[$quad->getGraph()][$quad->getSubject()][$quad->getPredicate()] = array();
            }
            $statementsByGraph[$quad->getGraph()][$quad->getSubject()][$quad->getPredicate()][] = $quad->getObject();
        }
        foreach ($statementsByGraph as $graph => $statements) {
            /* @var $graph string */
            /* @var $statements array() */
            $this->storeAdapter->addMultipleStatements($graph, $statements);
        }
    }

    /**
     * Checks if the provided SPARQL query is an ASK query.
     *
     * @param string $query
     * @return boolean
     */
    protected function isAskQuery($query)
    {
        if (strpos($query, 'ASK') === false) {
            // Query does not even contain the ASK keyword, no further
            // detection required.
            return false;
        }
        $parser = new Erfurt_Sparql_Parser();
        $info   = $parser->parse($query);
        return $info->getResultForm() === 'ask';
    }

}

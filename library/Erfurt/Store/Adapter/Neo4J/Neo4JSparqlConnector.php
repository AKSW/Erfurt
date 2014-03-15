<?php

/**
 * Connector for a Neo4J graph database that is used as triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_Neo4JSparqlConnector implements Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
{

    /**
     * Client that is used to execute SPARQL queries.
     *
     * @var Erfurt_Store_Adapter_Neo4J_SparqlApiClient
     */
    protected $sparqlApiClient = null;

    /**
     * Creates a connector that uses the provided SPARQL client.
     *
     * @param Erfurt_Store_Adapter_Neo4J_SparqlApiClient $sparqlApiClient
     */
    public function __construct(Erfurt_Store_Adapter_Neo4J_SparqlApiClient $sparqlApiClient)
    {
        $this->sparqlApiClient = $sparqlApiClient;
    }

    /**
     * Adds the provided triple to the data store.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple($graphIri, \Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        $object = $triple->getObject();
        if ($object['type'] === 'uri') {
            $objectDefinition = $object['value'];
        } else {
            $objectDefinition = $triple->format('?object');
        }
        $this->sparqlApiClient->insert(array(
            'subject'   => $triple->getSubject(),
            'predicate' => $triple->getPredicate(),
            'object'    => $objectDefinition,
            'graph'     => $graphIri
        ));
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
        $result = $this->sparqlApiClient->query($sparqlQuery);
        return $result;
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
        // TODO: Implement deleteMatchingTriples() method.
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
        return call_user_func($callback, $this);
    }

}

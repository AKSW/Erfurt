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
     * Converts received SPARQL results.
     *
     * @var Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
     */
    protected $resultConverter = null;

    /**
     * Creates a connector that uses the provided SPARQL client.
     *
     * @param Erfurt_Store_Adapter_Neo4J_SparqlApiClient $sparqlApiClient
     */
    public function __construct(Erfurt_Store_Adapter_Neo4J_SparqlApiClient $sparqlApiClient)
    {
        $this->sparqlApiClient = $sparqlApiClient;
        $this->resultConverter = new Erfurt_Store_Adapter_ResultConverter_CompositeConverter(array(
            new Erfurt_Store_Adapter_Neo4J_ResultConverter_RawToExtended(),
            new Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverter(
                new Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverter()
            )
        ));
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
        $query = $this->rewriteAskToSelect($sparqlQuery);
        $result = $this->sparqlApiClient->query($query);
        if ($query !== $sparqlQuery) {
            // This is an ASK query, which has been rewritten.
            // It is only important if the result set is empty or not.
            return count($result) > 0;
        }
        return $this->resultConverter->convert($result);
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

    /**
     * Rewrites ASK to SELECT queries as the SPARQL plugin does
     * not support ASK natively.
     *
     * If the type of the provided query is not ASK, then it
     * will be returned unchanged.
     *
     * @param string $query
     * @return string The rewritten query.
     */
    protected function rewriteAskToSelect($query)
    {
        if (strpos($query, 'ASK') === false) {
            // Query does not even contain the ASK keyword, no further
            // detection required.
            return $query;
        }
        $parser = new Erfurt_Sparql_Parser();
        $info   = $parser->parse($query);
        if ($info->getResultForm() !== 'ask') {
            return $query;
        }
        $askPosition = stripos($query, 'ASK ');
        // Replace ASK by a SELECT.
        $rewritten = substr($query, 0, $askPosition) . 'SELECT * ' . substr($query, $askPosition + 4);
        $modifiers = $info->getSolutionModifier();
        if (!isset($modifiers['limit'])) {
            // It should be safe to append a LIMIT, which reduces the result set (which is not needed).
            $rewritten .= ' LIMIT 1';
        }
        return $rewritten;
    }

}

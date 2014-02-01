<?php

/**
 * Minimal interface for connecting Erfurt to a triple store.
 *
 * Classes that implement this interface must be used with the GenericSparql adapter,
 * which provides the more verbose interface that is expected by Erfurt.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.02.14
 */
interface Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
{

    /**
     * Adds the provided triple to the data store.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple($graphIri, \Erfurt_Store_Adapter_Sparql_Triple $triple);

    /**
     * Executes the provided SPARQL query and returns its results.
     *
     * @param string $sparqlQuery
     * @return array|boolean
     */
    public function query($sparqlQuery);

    /**
     * Deletes all triples in the given graph that match the provided pattern.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_TriplePattern $pattern
     * @return integer The number of deleted triples.
     */
    public function deleteMatchingTriples($graphIri, Erfurt_Store_Adapter_Sparql_TriplePattern $pattern);

}

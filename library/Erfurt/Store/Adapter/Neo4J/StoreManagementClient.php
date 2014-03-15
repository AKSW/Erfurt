<?php

use Everyman\Neo4j\Client;
use Everyman\Neo4j\Cypher\Query;

/**
 * Used to manage a Neo4J triple store.
 *
 * This client assumes that the whole Neo4J database is used as triple store only.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_StoreManagementClient
{

    /**
     * The REST client that is used to communicate with Neo4J.
     *
     * @var \Everyman\Neo4j\Client
     */
    protected $apiClient = null;

    /**
     * Creates a management client that uses the provided REST API
     * client to communicate with the store.
     *
     * @param Client $restApiClient
     */
    public function __construct(Client $restApiClient)
    {
        $this->apiClient = $restApiClient;
    }

    /**
     * Removes all triples in the database.
     */
    public function clear()
    {
        $deletePredicates = 'START r=relationship(*) DELETE r';
        $operation = new Query($this->apiClient, $deletePredicates);
        $operation->getResultSet();
        $deleteNodes      = 'START n=node(*) DELETE n';
        $operation = new Query($this->apiClient, $deleteNodes);
        $operation->getResultSet();
    }

    /**
     * Returns the number of triples in the store.
     *
     * @return integer
     */
    public function getNumberOfTriples()
    {
        // Determine the number of edges, which is equivalent to the number of triples
        // as each triple has its own predicate (but subject and object might be shared
        // between triples).
        $query     = 'START n=node(*) MATCH (n)-[r]->() RETURN COUNT(r) AS numberOfTriples';
        $operation = new Query($this->apiClient, $query);
        $result    = $operation->getResultSet();
        return $result[0]['numberOfTriples'];
    }

}

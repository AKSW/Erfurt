<?php

use Everyman\Neo4j\Client;

/**
 * Used to manage a Neo4J triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_StoreManagementClient
{

    /**
     * Creates a management client that uses the provided REST API
     * client to communicate with the store.
     *
     * @param Client $restApiClient
     */
    public function __construct(Client $restApiClient)
    {

    }

    /**
     * Returns the number of triples in the store.
     *
     * @return integer
     */
    public function getNumberOfTriples()
    {

    }

}

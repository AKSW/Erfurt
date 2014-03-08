<?php

/**
 * Batch processor that uses SPARQL update queries to store quads.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_SparqlUpdateBatchProcessor
    implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The data access client that is used to interact with the store.
     *
     * @var Erfurt_Store_Adapter_Stardog_DataAccessClient
     */
    protected $client = null;

    public function __construct(Erfurt_Store_Adapter_Stardog_DataAccessClient $client)
    {

    }

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        // TODO: Implement persist() method.
    }

}

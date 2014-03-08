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
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        // TODO: Implement persist() method.
    }

}

<?php

/**
 * Batch processor that adds data in NQuads format.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 */
class Erfurt_Store_Adapter_Stardog_NQuadsBatchProcessor implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
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

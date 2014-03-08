<?php

/**
 * Interface for classes that insert quads as batch.
 *
 * It is up to the batch processor to choose the method that is most
 * suitable to store a given number of quads.
 *
 * Batch processors are useful in combination with quad buffers:
 * The buffer aggregates quads and once it is full these quads can
 * be passed to the batch processor for insertion.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 22.02.14
 */
interface Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads);

}

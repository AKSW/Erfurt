<?php

/**
 * Processor that assigns a quad list to different batch processor, depending
 * on the size of the quad set.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 */
class Erfurt_Store_Adapter_Sparql_SizeDependentBatchProcessor
    implements \Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * Creates a processor that passes quad sets to the given processors depending on the
     * given size value.
     *
     * @param integer $size The maximal number of quads that is handled by $smallProcessor.
     * @param Erfurt_Store_Adapter_Sparql_BatchProcessorInterface $smallProcessor
     * @param Erfurt_Store_Adapter_Sparql_BatchProcessorInterface $hugeProcessor
     */
    public function __construct(
        $size,
        \Erfurt_Store_Adapter_Sparql_BatchProcessorInterface $smallProcessor,
        \Erfurt_Store_Adapter_Sparql_BatchProcessorInterface $hugeProcessor
    ) {

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

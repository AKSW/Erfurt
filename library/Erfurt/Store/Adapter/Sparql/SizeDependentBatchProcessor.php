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
     * The processor that handles quad sets <= $size.
     *
     * @var Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
     */
    protected $smallProcessor = null;

    /**
     * The processor that handles quad sets > $size.
     *
     * @var Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
     */
    protected $hugeProcessor = null;

    /**
     * The size that is used to determine the responsible batch processor.
     *
     * @var integer
     */
    protected $size = null;

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
        $this->size = (int)$size;
        $this->smallProcessor = $smallProcessor;
        $this->hugeProcessor  = $hugeProcessor;
    }

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        $setSize = count($quads);
        if ($setSize === 0) {
            return;
        }
        if ($setSize <= $this->size) {
            $this->smallProcessor->persist($quads);
        } else {
            $this->hugeProcessor->persist($quads);
        }
    }

}

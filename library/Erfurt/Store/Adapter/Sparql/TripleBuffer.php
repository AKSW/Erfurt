<?php

/**
 * Buffer that can be used to insert triples in a batch.
 *
 * The buffer has a runtime configurable size. If the buffer is full,
 * the contained triples will be passed to a provided callback and
 * the buffer is cleared.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Sparql_TripleBuffer
{

    /**
     * Creates a triple buffer.
     *
     * The callback retrieves an array of triples whenever the buffer is flushed.
     *
     * @param callable $tripleHandler Callback that handles the triples on flush.
     * @param integer $size The size of the buffer.
     * @throws \InvalidArgumentException If an invalid callback is passed.
     */
    public function __construct($tripleHandler, $size = 1)
    {

    }

    /**
     * Adds a triple to the buffer.
     *
     * If the buffer size is reached after inserting the triple, then
     * it will be flushed.
     *
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple(Erfurt_Store_Adapter_Sparql_Triple $triple)
    {

    }

    /**
     * Passes all triples in the buffer to the handler and clears it.
     */
    public function flush()
    {

    }

    /**
     * Returns the current size of the buffer.
     *
     * @return integer
     */
    public function getSize()
    {

    }

    /**
     * Sets the new buffer size.
     *
     * If the current number of triples exceeds the new size, then the
     * buffer will be flushed.
     *
     * @param integer $newSize
     * @throws \InvalidArgumentException If the size is not valid.
     */
    public function setSize($newSize)
    {

    }

    /**
     * Returns the number of triples in the buffer.
     *
     * @return integer
     */
    public function count()
    {

    }

}

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
class Erfurt_Store_Adapter_Sparql_TripleBuffer implements Countable
{

    /**
     * Contains the buffered triples.
     *
     * @var array(\Erfurt_Store_Adapter_Sparql_Triple)
     */
    protected $triples = array();

    /**
     * The buffer size.
     *
     * As soon as this size is reached the buffer will be flushed.
     *
     * @var integer
     */
    protected $size = null;

    /**
     * The callback that processes the buffered triples once the buffer
     * is full.
     *
     * @var callable
     */
    protected $tripleHandler = null;

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
        if (!is_callable($tripleHandler)) {
            $message = 'Triple handler must be a valid callback.';
            throw new InvalidArgumentException($message);
        }
        $this->tripleHandler = $tripleHandler;
        $this->setSize($size);
    }

    /**
     * Adds a triple to the buffer.
     *
     * If the buffer size is reached after inserting the triple, then
     * it will be flushed.
     *
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function add(Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        $this->triples[] = $triple;
        $this->flushIfFull();
    }

    /**
     * Passes all triples in the buffer to the handler and clears it.
     */
    public function flush()
    {
        if ($this->isEmpty()) {
            //Nothing to flush.
            return;
        }
        call_user_func($this->tripleHandler, $this->triples);
        $this->clear();
    }

    /**
     * Returns the current size of the buffer.
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
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
        if (!is_int($newSize)) {
            $message = 'Buffer size must be an integer, but received ' . gettype($newSize) . '.';
            throw new InvalidArgumentException($message);
        }
        if ($newSize < 1) {
            $message = 'Buffer size must be at least 1.';
            throw new InvalidArgumentException($message);
        }
        $this->size = $newSize;
        $this->flushIfFull();
    }

    /**
     * Returns the number of triples in the buffer.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->triples);
    }

    /**
     * Flushes the buffer if it is full.
     *
     * Does nothing if the number of triples is within the allowed size.
     */
    protected function flushIfFull()
    {
        if ($this->count() < $this->size) {
            // Number of triples does not exceed buffer size.
            return;
        }
        $this->flush();
    }

    /**
     * Clears the buffer.
     *
     * All triples will be removed, but the triple handler will *not*
     * be notified.
     */
    protected function clear()
    {
        $this->triples = array();
    }

    /**
     * Checks if the buffer is empty.
     *
     * @return boolean
     */
    protected function isEmpty()
    {
        return $this->count() === 0;
    }

}

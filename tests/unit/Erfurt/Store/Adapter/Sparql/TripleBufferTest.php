<?php

/**
 * Tests the triple buffer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Sparql_TripleBufferTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Ensures that the constructor throws an exception if no valid callback
     * passed.
     */
    public function testConstructorThrowsExceptionIfNoValidCallbackIsProvided()
    {

    }

    /**
     * Ensures that the constructor throws an exception if an invalid
     * size is passed.
     */
    public function testConstructorThrowsExceptionIfInvalidSizeIsPassed()
    {

    }

    /**
     * Checks if the buffer is countable.
     */
    public function testBufferIsCountable()
    {

    }

    /**
     * Ensures that the buffer is initially empty.
     */
    public function testBufferIsInitiallyEmpty()
    {

    }

    /**
     * Checks if count() returns the correct number of triples
     * when the buffer is not empty.
     */
    public function testCountReturnsNumberOfTriplesInBuffer()
    {

    }

    /**
     * Ensures that setSize() throws an exception if an invalid buffer size
     * is passed.
     */
    public function testSetSizeThrowsExceptionIfInvalidBufferSizeIsPassed()
    {

    }

    /**
     * Checks if getSize() returns the size that has been passed to the
     * constructor.
     */
    public function testGetSizeReturnsInitiallyConfiguredSize()
    {

    }

    /**
     * Checks if getSize() returns the buffer size that has been updated
     * via setSize().
     */
    public function testGetSizeReturnsUpdatedBufferSize()
    {

    }

    /**
     * Checks if flush() clears the buffer.
     */
    public function testFlushClearsBuffer()
    {

    }

    /**
     * Ensures that flush() passes the triples in the buffer to the
     * callback.
     */
    public function testFlushPassesTriplesToCallback()
    {

    }

    /**
     * Ensures that flush() does not invoke the callback if the
     * buffer is empty.
     */
    public function testFlushDoesNotInvokeCallbackIfBufferIsEmpty()
    {

    }

    /**
     * Ensures that addTriple() does not flush the buffer if the buffer
     * size is not reached.
     */
    public function testAddTripleDoesNotFlushIfBufferSizeIsNotExceeded()
    {

    }

    /**
     * Ensures that addTriple() flushes the buffer if the buffer
     * size is reached.
     */
    public function testAddTripleFlushesBufferIfBufferSizeIsReached()
    {

    }

    /**
     * Ensures that setSize() flushes the buffer if the number of
     * triples exceeds the new buffer size.
     */
    public function testSetSizeFlushesBufferIfSizeIsExceeded()
    {

    }

    /**
     * Ensures that setSize() does not flush the buffer if the number
     * of triples does *not* exceed the new buffer size.
     */
    public function testSetSizeDoesNotFlushBufferIfSizeIsNotExceeded()
    {

    }

}

<?php

/**
 * Tests the triple buffer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Sparql_TripleBufferTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructorThrowsExceptionIfNoValidCallbackIsProvided()
    {

    }

    public function testConstructorThrowsExceptionIfInvalidSizeIsPassed()
    {

    }

    public function testBufferIsCountable()
    {

    }

    public function testBufferIsInitiallyEmpty()
    {

    }

    public function testCountReturnsNumberOfTriplesInBuffer()
    {

    }

    public function testGetSizeReturnsInitiallyConfiguredSize()
    {

    }

    public function testGetSizeReturnsUpdatedBufferSize()
    {

    }

    public function testFlushClearsBuffer()
    {

    }

    public function testFlushPassesTriplesToCallback()
    {

    }

    public function testFlushDoesNotInvokeCallbackIfBufferIsEmpty()
    {

    }

    public function testAddTripleDoesNotFlushIfBufferSizeIsNotExceeded()
    {

    }

    public function testAddTripleFlushesBufferIfBufferSizeIsReached()
    {

    }

    public function testSetSizeFlushesBufferIfSizeIsExceeded()
    {
        
    }

}

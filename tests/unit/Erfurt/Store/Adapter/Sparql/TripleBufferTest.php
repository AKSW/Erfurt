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
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_TripleBuffer
     */
    protected $buffer = null;

    /**
     * The mocked callback that is called on flush.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $flushCallback = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->flushCallback = $this->getMock('stdClass', array('__invoke'));
        $this->buffer        = new Erfurt_Store_Adapter_Sparql_TripleBuffer($this->flushCallback, 3);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->buffer        = null;
        $this->flushCallback = null;
        parent::tearDown();
    }

    /**
     * Ensures that the constructor throws an exception if no valid callback
     * passed.
     */
    public function testConstructorThrowsExceptionIfNoValidCallbackIsProvided()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Sparql_TripleBuffer(array($this, 'missing'), 2);
    }

    /**
     * Ensures that the constructor throws an exception if an invalid
     * size is passed.
     */
    public function testConstructorThrowsExceptionIfInvalidSizeIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Sparql_TripleBuffer($this->flushCallback, -1);
    }

    /**
     * Checks if the buffer is countable.
     */
    public function testBufferIsCountable()
    {
        $this->assertInstanceOf('Countable', $this->buffer);
    }

    /**
     * Ensures that the buffer is initially empty.
     */
    public function testBufferIsInitiallyEmpty()
    {
        $this->assertEquals(0, $this->buffer->count());
    }

    /**
     * Checks if count() returns the correct number of triples
     * when the buffer is not empty.
     */
    public function testCountReturnsNumberOfTriplesInBuffer()
    {
        $this->buffer->add($this->createTriple());

        $this->assertEquals(1, $this->buffer->count());
    }

    /**
     * Ensures that setSize() throws an exception if an invalid buffer size
     * is passed.
     */
    public function testSetSizeThrowsExceptionIfInvalidBufferSizeIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->buffer->setSize(new stdClass());
    }

    /**
     * Ensures that setSize() does not accept 0 as buffer size.
     *
     * The size of the buffer must be at least 1. It is flushed
     * when this size is reached.
     */
    public function testSetSizeDoesNotAcceptZero()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->buffer->setSize(0);
    }

    /**
     * Checks if getSize() returns the size that has been passed to the
     * constructor.
     */
    public function testGetSizeReturnsInitiallyConfiguredSize()
    {
        $this->assertEquals(3, $this->buffer->getSize());
    }

    /**
     * Checks if getSize() returns the buffer size that has been updated
     * via setSize().
     */
    public function testGetSizeReturnsUpdatedBufferSize()
    {
        $this->buffer->setSize(42);
        $this->assertEquals(42, $this->buffer->getSize());
    }

    /**
     * Checks if flush() clears the buffer.
     */
    public function testFlushClearsBuffer()
    {
        $this->buffer->add($this->createTriple());
        $this->buffer->add($this->createTriple());

        $this->buffer->flush();

        $this->assertEquals(0, $this->buffer->count());
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
     * Ensures that add() does not flush the buffer if the buffer
     * size is not reached.
     */
    public function testAddDoesNotFlushIfBufferSizeIsNotExceeded()
    {

    }

    /**
     * Ensures that add() flushes the buffer if the buffer
     * size is reached.
     */
    public function testAddFlushesBufferIfBufferSizeIsReached()
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

    /**
     * Creates a triple with random content.
     *
     * @return Erfurt_Store_Adapter_Sparql_Triple
     */
    protected function createTriple()
    {
        return new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/' . uniqid('sub'),
            'http://example.org/' . uniqid('pred'),
            array(
                'type'  => 'uri',
                'value' => 'http://example.org/' . uniqid('obj')
            )
        );
    }

}

<?php

/**
 * Tests the quad buffer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Sparql_QuadBufferTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_QuadBuffer
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
        $this->buffer        = new Erfurt_Store_Adapter_Sparql_QuadBuffer($this->flushCallback, 3);
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
        new Erfurt_Store_Adapter_Sparql_QuadBuffer(array($this, 'missing'), 2);
    }

    /**
     * Ensures that the constructor throws an exception if an invalid
     * size is passed.
     */
    public function testConstructorThrowsExceptionIfInvalidSizeIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Sparql_QuadBuffer($this->flushCallback, -1);
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
     * Checks if count() returns the correct number of quads
     * when the buffer is not empty.
     */
    public function testCountReturnsNumberOfQuadsInBuffer()
    {
        $this->buffer->add($this->createQuad());

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
        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());

        $this->buffer->flush();

        $this->assertEquals(0, $this->buffer->count());
    }

    /**
     * Ensures that flush() passes the quads in the buffer to the
     * callback.
     */
    public function testFlushPassesQuadsToCallback()
    {
        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());

        $this->assertCallbackReceivesQuads($this->buffer->count());

        $this->buffer->flush();
    }

    /**
     * Ensures that flush() does not invoke the callback if the
     * buffer is empty.
     */
    public function testFlushDoesNotInvokeCallbackIfBufferIsEmpty()
    {
        $this->assertCallbackNotCalled();

        $this->buffer->flush();
    }

    /**
     * Ensures that the buffer is cleared even if the callback throws an exception.
     */
    public function testFlushEmptiesBufferEvenIfCallbackThrowsException()
    {
        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());

        $this->flushCallback->expects($this->once())
                            ->method('__invoke')
                            ->will($this->throwException(new RuntimeException('Error in callback.')));

        $this->setExpectedException('RuntimeException');
        try {
            $this->buffer->flush();
        } catch (RuntimeException $e) {
            $this->assertEquals(0, $this->buffer->count(), 'Buffer was not cleared.');
            throw $e;
        }
    }

    /**
     * Ensures that add() does not flush the buffer if the buffer
     * size is not reached.
     */
    public function testAddDoesNotFlushIfBufferSizeIsNotExceeded()
    {
        $this->assertCallbackNotCalled();

        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());
    }

    /**
     * Ensures that add() flushes the buffer if the buffer
     * size is reached.
     */
    public function testAddFlushesBufferIfBufferSizeIsReached()
    {
        $this->assertCallbackReceivesQuads(3);

        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());
    }

    /**
     * Ensures that setSize() flushes the buffer if the number of
     * quads exceeds the new buffer size.
     */
    public function testSetSizeFlushesBufferIfSizeIsExceeded()
    {
        $this->assertCallbackReceivesQuads(2);

        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());

        $this->buffer->setSize(1);
    }

    /**
     * Ensures that setSize() does not flush the buffer if the number
     * of quads does *not* exceed the new buffer size.
     */
    public function testSetSizeDoesNotFlushBufferIfSizeIsNotExceeded()
    {
        $this->assertCallbackNotCalled();

        $this->buffer->add($this->createQuad());
        $this->buffer->add($this->createQuad());

        $this->buffer->setSize(42);
    }

    /**
     * Asserts that the callback receives the provided number of triples.
     *
     * @param integer $numberOfQuads
     */
    protected function assertCallbackReceivesQuads($numberOfQuads)
    {
        $checkQuads = function ($triples) use ($numberOfQuads) {
            PHPUnit_Framework_Assert::assertInternalType('array', $triples);
            PHPUnit_Framework_Assert::assertContainsOnly('\Erfurt_Store_Adapter_Sparql_Quad', $triples);
            PHPUnit_Framework_Assert::assertCount($numberOfQuads, $triples);
        };
        $this->flushCallback->expects($this->once())
                            ->method('__invoke')
                            ->will($this->returnCallback($checkQuads));
    }

    /**
     * Asserts that the flush callback is *not* called.
     */
    protected function assertCallbackNotCalled()
    {
        $this->flushCallback->expects($this->never())
                            ->method('__invoke');
    }

    /**
     * Creates a quad with random content.
     *
     * @return Erfurt_Store_Adapter_Sparql_Quad
     */
    protected function createQuad()
    {
        return new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/' . uniqid('sub'),
            'http://example.org/' . uniqid('pred'),
            array(
                'type'  => 'uri',
                'value' => 'http://example.org/' . uniqid('obj')
            ),
            'http://example.org/graph'
        );
    }

}

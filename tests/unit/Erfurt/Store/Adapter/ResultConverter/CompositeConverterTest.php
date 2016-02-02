<?php

/**
 * Tests the composite converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_ResultConverter_CompositeConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_ResultConverter_CompositeConverter
     */
    protected $converter = null;

    /**
     * The first mocked converter in the composite.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $firstInnerConverter = null;

    /**
     * The second mocked converter in the composite.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $secondInnerConverter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->firstInnerConverter  = $this->getMock('Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface');
        $this->secondInnerConverter = $this->getMock('Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface');
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_CompositeConverter(
            array($this->firstInnerConverter, $this->secondInnerConverter)
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->secondInnerConverter = null;
        $this->firstInnerConverter  = null;
        $this->converter            = null;
        parent::tearDown();
    }

    /**
     * Checks if the converter implements the necessary interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('\Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface', $this->converter);
    }

    /**
     * Ensures that  the unmodified result set is returned by convert() if no
     * converter was passed to the composite.
     */
    public function testCompositeReturnsUnchangedResultIfNoConverterIsProvided()
    {
        $resultSet = array(array(1, 2, 3));
        $converter = new Erfurt_Store_Adapter_ResultConverter_CompositeConverter(array());

        $converted = $converter->convert($resultSet);

        $this->assertEquals($resultSet, $converted);
    }

    /**
     * Checks if the result set is passed to the first converter.
     */
    public function testCompositePassesResultSetToFirstConverter()
    {
        $this->firstInnerConverter->expects($this->once())
                                  ->method('convert')
                                  ->with(42);

        $this->converter->convert(42);
    }

    /**
     * Ensures that the result of the first converter is passed to
     * the second one.
     */
    public function testCompositePassesResultFromFirstToSecondConverter()
    {
        $this->firstInnerConverter->expects($this->any())
                                  ->method('convert')
                                  ->will($this->returnValue(7));
        $this->secondInnerConverter->expects($this->once())
                                   ->method('convert')
                                   ->with(7);

        $this->converter->convert(42);
    }

    /**
     * Checks if the result of the last converter is returned by convert().
     */
    public function testCompositeReturnsResultFromLastConverter()
    {
        $this->secondInnerConverter->expects($this->once())
                                   ->method('convert')
                                   ->will($this->returnValue(7));

        $converted = $this->converter->convert(42);

        $this->assertEquals(7, $converted);
    }

}

<?php

/**
 * Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverterTest
 *
 * @category PHP
 * @package 
 * @author Matthias Molitor <matthias@matthimatiker.de>
 * @copyright 2013 Wuzzitor
 * @license proprietary
 * @link https://github.com/Wuzzitor/Erfurt
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverter();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->converter = null;
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
     * Ensures that an exception is thrown by convert() if no array is passed.
     */
    public function testConvertThrowsExceptionIfNoArrayIsPassed()
    {
        $this->setExpectedException('Erfurt_Store_Adapter_ResultConverter_Exception');
        $this->converter->convert(new stdClass());
    }

    public function testConvertDoesNotChangeNumberOfRows()
    {

    }

    public function testConvertDoesChangeNumberOfColumns()
    {

    }

    public function testConvertConvertsBooleanValueCorrectly()
    {

    }
    public function testConvertConvertsIntegerValueCorrectly()
    {

    }

    public function testConvertConvertsDoubleValueCorrectly()
    {

    }

    public function testConvertConvertsStringValueCorrectly()
    {

    }

    public function testConvertDoesNotChangeUntypedValue()
    {

    }

}

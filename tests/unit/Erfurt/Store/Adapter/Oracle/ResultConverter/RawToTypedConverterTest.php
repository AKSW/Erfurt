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

    /**
     * Ensures that convert() does not change the number of rows in the result set.
     */
    public function testConvertDoesNotChangeNumberOfRows()
    {

    }

    /**
     * Ensures that convert() does not change the number of columns in the result set.
     */
    public function testConvertDoesChangeNumberOfColumns()
    {

    }

    /**
     * Checks if convert() changes a boolean value correctly.
     */
    public function testConvertConvertsBooleanValueCorrectly()
    {

    }

    /**
     * Checks if convert() changes integer values correctly.
     */
    public function testConvertConvertsIntegerValueCorrectly()
    {

    }

    /**
     * Checks if convert() changes double values correctly.
     */
    public function testConvertConvertsDoubleValueCorrectly()
    {

    }

    /**
     * Checks if convert() returns string values correctly typed.
     */
    public function testConvertConvertsStringValueCorrectly()
    {

    }

    /**
     * Ensures that convert() does not change untyped values.
     */
    public function testConvertDoesNotChangeUntypedValue()
    {

    }

    /**
     * Checks if convert() ignores unknown types.
     */
    public function testConvertDoesNotChangeValuesOfUnknownType()
    {

    }

}

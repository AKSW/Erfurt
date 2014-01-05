<?php

/**
 * Tests the converter that removes variable prefixes.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 05.01.14
 */
class Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter('pre_');
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
     * Checks if the converter implements the required interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('\Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface', $this->converter);
    }

    /**
     * Ensures that convert() throws an exception if no array is passed.
     */
    public function testConvertThrowsExceptionIfNoArrayIsPassed()
    {
        $this->setExpectedException('Erfurt_Store_Adapter_ResultConverter_Exception');
        $this->converter->convert(new stdClass());
    }

    /**
     * Ensures that the converter does not change a variable without prefix.
     */
    public function testConvertDoesNotChangeVariableWithoutPrefix()
    {
        $input = array(
            array('no_prefix' => 42)
        );

        $converted = $this->converter->convert($input);

        $this->assertInternalType('array', $converted);
        $row = current($converted);
        $this->assertInternalType('array', $row);
        $this->assertArrayHasKey('no_prefix', $row);
    }

    /**
     * Checks if the converter removes the prefix from the variable.
     */
    public function testConvertRemovesPrefix()
    {
        $input = array(
            array('pre_test' => 42)
        );

        $converted = $this->converter->convert($input);

        $this->assertInternalType('array', $converted);
        $row = current($converted);
        $this->assertInternalType('array', $row);
        $this->assertArrayHasKey('test', $row);
    }

    /**
     * Ensures that convert() does not change the column value.
     */
    public function testConvertDoesNotChangeColumnValue()
    {
        $input = array(
            array('pre_test' => 42)
        );

        $converted = $this->converter->convert($input);

        $this->assertInternalType('array', $converted);
        $value = current(current($converted));
        $this->assertEquals(42, $value);
    }

    /**
     * Ensures that the old (prefixed) variable key is removed.
     */
    public function testConvertRemovesPreviousKey()
    {
        $input = array(
            array('pre_test' => 42)
        );

        $converted = $this->converter->convert($input);

        $this->assertInternalType('array', $converted);
        $row = current($converted);
        $this->assertInternalType('array', $row);
        $this->assertArrayNotHasKey('pre_test', $row);
    }

}

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

    }

    /**
     * Checks if the converter removes the prefix from the variable.
     */
    public function testConvertRemovesPrefix()
    {

    }

    /**
     * Ensures that the old (prefixed) variable key is removed.
     */
    public function testConvertRemovesPreviousKey()
    {

    }

}

<?php

/**
 * Tests the XML converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_Stardog_ResultConverter_XmlToBooleanConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Stardog_ResultConverter_XmlToBooleanConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Stardog_ResultConverter_XmlToBooleanConverter();
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

    public function testConverterReturnsFalseIfNoXmlIsPassed()
    {

    }

    public function testConverterReturnsTrueIfXmlContainsBooleanValueTrue()
    {

    }

    public function testConverterReturnsFalseIfXmlContainsBooleanValueFalse()
    {

    }

}

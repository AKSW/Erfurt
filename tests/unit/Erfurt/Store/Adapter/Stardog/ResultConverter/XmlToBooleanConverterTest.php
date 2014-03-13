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

    /**
     * Ensures that the converter returns false if the expected SimpleXMLElement is not passed.
     */
    public function testConverterReturnsFalseIfNoXmlIsPassed()
    {
        $this->assertFalse($this->converter->convert(new \stdClass()));
    }

    /**
     * Ensures that the converter returns true if the XML contains the value "true".
     */
    public function testConverterReturnsTrueIfXmlContainsBooleanValueTrue()
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>"
             . "<sparql xmlns='http://www.w3.org/2005/sparql-results#'>"
             . "    <head></head>"
             . "    <boolean>true</boolean>"
             . "</sparql>";

        $this->assertTrue($this->converter->convert(new SimpleXMLElement($xml)));
    }

    /**
     * Ensures that the converter returns false if the XML contains the value "false".
     */
    public function testConverterReturnsFalseIfXmlContainsBooleanValueFalse()
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>"
             . "<sparql xmlns='http://www.w3.org/2005/sparql-results#'>"
             . "    <head></head>"
             . "    <boolean>false</boolean>"
             . "</sparql>";

        $this->assertFalse($this->converter->convert(new SimpleXMLElement($xml)));
    }

}

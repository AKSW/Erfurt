<?php

/**
 * Tests the JSON converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 19.01.14
 */
class Erfurt_Store_Adapter_ResultConverter_ToJsonConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_ResultConverter_ToJsonConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_ToJsonConverter();
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
     * Ensures that convert() returns a string.
     */
    public function testConvertReturnsString()
    {
        $data = array(
            array('subject' => 'http://example.org', 'object' => 42)
        );

        $converted = $this->converter->convert($data);

        $this->assertInternalType('string', $converted);
    }

    /**
     * Checks if the string that is returned by convert() contains valid JSON.
     */
    public function testConvertReturnsValidJson()
    {
        $data = array(
            array('subject' => 'http://example.org', 'object' => 42)
        );

        $json = $this->converter->convert($data);

        $this->assertInternalType('string', $json);

        $this->setExpectedException(null);
        Zend_Json::decode($json);
    }

}

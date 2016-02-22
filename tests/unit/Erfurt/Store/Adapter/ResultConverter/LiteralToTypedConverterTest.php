<?php

/**
 * Tests the converter that casts literal values.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverter();
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
     * Ensures that URI values are not changed.
     */
    public function testConverterDoesNotChangeUris()
    {
        $value = array(
            'type'  => 'uri',
            'value' => 'http://example.org'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Ensures that string literals are not changed.
     */
    public function testConverterDoesNotChangeStrings()
    {
        $value = array(
            'type'     => 'literal',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#string',
            'value'    => 'Hello world.'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Ensures that untyped literals are not changed.
     */
    public function testConverterDoesNotChangeUntypedLiterals()
    {
        $value = array(
            'type'     => 'literal',
            'value'    => 'Hello world.'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Checks if boolean literals are casted correctly.
     */
    public function testConverterCastsBooleanLiteralsCorrectly()
    {
        $value = array(
            'type'     => 'literal',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#boolean',
            'value'    => 'false'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertFalse($converted['value']);
    }

    /**
     * Checks if integer literals are casted correctly.
     */
    public function testConverterCastsIntegerValuesCorrectly()
    {
        $value = array(
            'type'     => 'literal',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#integer',
            'value'    => '42'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertInternalType('integer', $converted['value']);
        $this->assertEquals(42, $converted['value']);
    }

    /**
     * Checks if double literals are casted correctly.
     */
    public function testConverterCastsDoubleValuesCorrectly()
    {
        $value = array(
            'type'     => 'literal',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#double',
            'value'    => '42.42'
        );

        $converted = $this->converter->convert($value);

        $this->assertInternalType('array', $converted);
        $this->assertInternalType('float', $converted['value']);
        $this->assertEquals(42.42, $converted['value']);
    }

}

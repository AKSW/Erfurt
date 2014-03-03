<?php

/**
 * Tests the converter that casts literal values in an extended result set.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedToTypedConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_ExtendedToTypedConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_ExtendedToTypedConverter();
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
        $result = $this->getExtendedResult($value);

        $converted = $this->converter->convert($result);

        $this->assertInternalType('array', $converted);
        $this->assertEquals($value, $converted['results']['bindings'][0]['value']);
    }

    /**
     * Ensures that string literals are not changed.
     */
    public function testConverterDoesNotChangeString()
    {
        $value = array(
            'type'     => 'literal',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#string',
            'value'    => 'Hello world.'
        );
        $result = $this->getExtendedResult($value);

        $converted = $this->converter->convert($result);

        $this->assertInternalType('array', $converted);
        $this->assertEquals($value, $converted['results']['bindings'][0]['value']);
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
        $result = $this->getExtendedResult($value);

        $converted = $this->converter->convert($result);

        $this->assertInternalType('array', $converted);
        $convertedValue = $converted['results']['bindings'][0]['value'];
        $this->assertFalse($convertedValue['value']);
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
        $result = $this->getExtendedResult($value);

        $converted = $this->converter->convert($result);

        $this->assertInternalType('array', $converted);
        $convertedValue = $converted['results']['bindings'][0]['value'];
        $this->assertInternalType('integer', $convertedValue['value']);
        $this->assertEquals(42, $convertedValue['value']);
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
        $result = $this->getExtendedResult($value);

        $converted = $this->converter->convert($result);

        $this->assertInternalType('array', $converted);
        $convertedValue = $converted['results']['bindings'][0]['value'];
        $this->assertInternalType('float', $convertedValue['value']);
        $this->assertEquals(42.42, $convertedValue['value']);
    }

    /**
     * Creates a SPARQL result in extended that contains a single row with
     * a single value (Variable: value) that is specified by $valueSpecification.
     *
     * @param array(string=>string)
     * @return array(mixed)
     */
    protected function getExtendedResult(array $valueSpecification)
    {
        return array(
            'head' => array(
                'vars' => array(
                    'value'
                )
            ),
            'results' => array(
                'bindings' => array(
                    array(
                        'value' => $valueSpecification
                    )
                )
            )
        );
    }

}

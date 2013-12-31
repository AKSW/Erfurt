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

    /**
     * Returns an example result set.
     *
     * The result set contains several rows each containing an OBJECT
     * variable of different types.
     *
     * All available types are documented at {@link http://www.w3.org/TR/xmlschema-2/#built-in-datatypes}.
     *
     * @return array(array(string=>string|null))
     */
    protected function getRawResultSet()
    {
        return array(
            // URI
            array(
                'OBJECT'            => 'http://www.example.org/object',
                'OBJECT$RDFVID'     => 6944352155936009563,
                'OBJECT$_PREFIX'    => 'http://www.example.org/',
                'OBJECT$_SUFFIX'    => 'object',
                'OBJECT$RDFVTYP'    => 'URI',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 1
            ),
            // Boolean
            array(
                'OBJECT'            => 'false',
                'OBJECT$RDFVID'     => 6944352155936009564,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => 'http://www.w3.org/2001/XMLSchema#boolean',
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 2
            ),
            // Integer
            array(
                'OBJECT'            => '42',
                'OBJECT$RDFVID'     => 6944352155936009565,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => 'http://www.w3.org/2001/XMLSchema#int',
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 3
            ),
            // Double
            array(
                'OBJECT'            => '42.42',
                'OBJECT$RDFVID'     => 6944352155936009566,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => 'http://www.w3.org/2001/XMLSchema#float',
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 4
            ),
            // String
            array(
                'OBJECT'            => 'Hello world!',
                'OBJECT$RDFVID'     => 6944352155936009567,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => 'http://www.w3.org/2001/XMLSchema#string',
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 5
            ),
            // Untyped
            array(
                'OBJECT'            => 'Hello world!',
                'OBJECT$RDFVID'     => 6944352155936009568,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 6
            ),
            // Custom type
            array(
                'OBJECT'            => '5 * (2 + 3)',
                'OBJECT$RDFVID'     => 6944352155936009569,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => 'http://example.org/types#formula',
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 7
            )
        );
    }

}

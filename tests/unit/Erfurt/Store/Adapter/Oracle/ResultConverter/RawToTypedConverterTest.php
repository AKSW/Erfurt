<?php

/**
 * Tests the RawToTyped converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
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
        $loader = $this->getMockBuilder('Erfurt_Store_Adapter_Oracle_ClobLiteralLoader')
                       ->disableOriginalConstructor()
                       ->getMock();
        $loader->expects($this->any())
               ->method('load')
               ->will($this->returnCallback(function () {
                   return Erfurt_Store_Adapter_Oracle_ResultConverter_Util::buildLiteral(str_repeat('x', 4200));
               }));
        $this->converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverter($loader);
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
        $exampleData = $this->getRawResultSet();

        $converted = $this->converter->convert($exampleData);

        $this->assertInternalType('array', $converted);
        $this->assertCount(count($exampleData), $converted);
    }

    /**
     * Ensures that convert() does not change the number of columns in the result set.
     */
    public function testConvertDoesNotChangeNumberOfColumns()
    {
        $exampleData = $this->getRawResultSet();

        $converted = $this->converter->convert($exampleData);

        $this->assertInternalType('array', $converted);
        foreach ($converted as $index => $row) {
            /* @var $row array(string=>mixed) */
            $this->assertInternalType('array', $row);
            $this->assertCount(count($exampleData[$index]), $row);
        }
    }

    /**
     * Ensures that convert() does not change URI values.
     */
    public function testConvertDoesNotChangeUri()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 0);
        $this->assertInternalType('string', $value);
        $this->assertEquals('http://www.example.org/object', $value);
    }

    /**
     * Checks if convert() changes a boolean value correctly.
     */
    public function testConvertConvertsBooleanValueCorrectly()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 1);
        $this->assertFalse($value);
    }

    /**
     * Checks if convert() changes integer values correctly.
     */
    public function testConvertConvertsIntegerValueCorrectly()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 2);
        $this->assertInternalType('integer', $value);
        $this->assertEquals(42, $value);
    }

    /**
     * Checks if convert() changes double values correctly.
     */
    public function testConvertConvertsDoubleValueCorrectly()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 3);
        $this->assertInternalType('float', $value);
        $this->assertEquals(42.42, $value);
    }

    /**
     * Checks if convert() returns string values correctly typed.
     */
    public function testConvertConvertsStringValueCorrectly()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 4);
        $this->assertInternalType('string', $value);
        $this->assertEquals('Hello world!', $value);
    }

    /**
     * Ensures that convert() does not change untyped values.
     */
    public function testConvertDoesNotChangeUntypedValue()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 5);
        $this->assertInternalType('string', $value);
        $this->assertEquals('Hello world!', $value);
    }

    /**
     * Checks if convert() ignores unknown types.
     */
    public function testConvertDoesNotChangeValuesOfUnknownType()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 6);
        $this->assertInternalType('string', $value);
        $this->assertEquals('5 * (2 + 3)', $value);
    }

    /**
     * Checks if long literal values are extracted correctly.
     */
    public function testConvertExtractsLongLiteralsCorrectly()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 7);

        $this->assertInternalType('string', $value);
        $this->assertEquals(str_repeat('x', 4200), $value);
    }

    /**
     * Checks if convert() can work with a  minimal result set.
     *
     * This is a result set that is assembled by the SPARQL wrapper.
     */
    public function testConvertWorksWithMinimalDataSet()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 8);

        $this->assertInternalType('string', $value);
        $this->assertEquals('Test', $value);
    }

    /**
     * Ensures that convert() loads missing CLOBs if necessary.
     *
     * For performance reason, the SPARQL wrapper excludes CLOBs from the
     * result set. These must be loaded manually afterwards.
     */
    public function testConvertLoadsClobIfNecessary()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $value = $this->getValueFromRow($converted, 9);

        $this->assertInternalType('string', $value);
        $this->assertEquals(str_repeat('x', 4200), $value);
    }

    /**
     * Returns the data value from row $rowIndex in the
     * provided result set.
     *
     * @param array(string=>mixed) $converted
     * @param integer $rowIndex
     * @return mixed
     */
    protected function getValueFromRow($converted, $rowIndex)
    {
        $this->assertInternalType('array', $converted);
        $this->assertArrayHasKey($rowIndex, $converted);
        $row = $converted[$rowIndex];
        $this->assertInternalType('array', $row);
        $this->assertArrayHasKey('OBJECT', $row);
        return $row['OBJECT'];
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
            ),
            // Long literal (more that 4000 characters)
            array(
                'OBJECT'            => 'ORALL1',
                'OBJECT$RDFVID'     => 6944352155936009570,
                'OBJECT$_PREFIX'    => null,
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => str_repeat('x', 4200),
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 8
            ),
            // Minimal data set.
            array(
                'OBJECT'            => 'Test',
                'OBJECT$RDFVID'     => 6944352155936009571,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$HAS_CLOB'   => false,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 9
            ),
            // CLOB value that must be lazy loaded.
            array(
                'OBJECT'            => null,
                'OBJECT$RDFVID'     => 6944352155936009572,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$HAS_CLOB'   => true,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 10
            )
        );
    }

}

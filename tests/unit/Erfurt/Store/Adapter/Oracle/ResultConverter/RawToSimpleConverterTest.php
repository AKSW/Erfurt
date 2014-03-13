<?php

/**
 * Tests the RawToSimple result converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.12.13
 */
class Erfurt_Store_Adapter_Oracle_RawToSimpleConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_ResultConverter_RawToSimpleConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RawToSimpleConverter();
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
     * Checks if variable names are converted into lower case.
     */
    public function testConvertChangesVariablesToLowerCase()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $this->assertInternalType('array', $converted);
        $this->assertCount(2, $converted);
        $firstRow = current($converted);
        $this->assertArrayHasKey('subject', $firstRow);
        $this->assertArrayHasKey('predicate', $firstRow);
        $this->assertArrayHasKey('object', $firstRow);
    }

    /**
     * Ensures that unnecessary columns (variable types, order values etc.)
     * are removed from the result set.
     */
    public function testConvertRemovesUnnecessaryColumns()
    {
        $converted = $this->converter->convert($this->getRawResultSet());

        $this->assertInternalType('array', $converted);
        $this->assertCount(2, $converted);
        $firstRow = current($converted);
        // Each row must contain only the variables.
        $this->assertCount(3, $firstRow);
    }

    /**
     * Ensures that convert() can handle an empty result set.
     */
    public function testConvertCanHandleEmptyResultSet()
    {
        $converted = $this->converter->convert(array());

        $this->assertEquals(array(), $converted);
    }

    /**
     * Returns an example result set.
     *
     * The result set contains 2 rows and uses the variables SUBJECT,
     * PREDICATE and OBJECT.
     *
     * @return array(array(string=>string|null))
     */
    protected function getRawResultSet()
    {
        return array(
            array(
                'SUBJECT'           => 'http://www.example.org/subject',
                'SUBJECT$RDFVID'    => 7614293122126211127,
                'SUBJECT$_PREFIX'   => 'http://www.example.org/',
                'SUBJECT$_SUFFIX'   => 'subject',
                'SUBJECT$RDFVTYP'   => 'URI',
                'SUBJECT$RDFCLOB'   => null,
                'SUBJECT$RDFLTYP'   => null,
                'SUBJECT$RDFLANG'   => null,
                'PREDICATE'         => 'http://www.example.org/predicate',
                'PREDICATE$RDFVID'  => 8663359142594985318,
                'PREDICATE$_PREFIX' => 'http://www.example.org/',
                'PREDICATE$_SUFFIX' => 'predicate',
                'PREDICATE$RDFVTYP' => 'URI',
                'PREDICATE$RDFCLOB' => null,
                'PREDICATE$RDFLTYP' => null,
                'PREDICATE$RDFLANG' => null,
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
            array(
                'SUBJECT'           => 'http://www.example.org/subject',
                'SUBJECT$RDFVID'    => 7614293122126211127,
                'SUBJECT$_PREFIX'   => 'http://www.example.org/',
                'SUBJECT$_SUFFIX'   => 'subject',
                'SUBJECT$RDFVTYP'   => 'URI',
                'SUBJECT$RDFCLOB'   => null,
                'SUBJECT$RDFLTYP'   => null,
                'SUBJECT$RDFLANG'   => null,
                'PREDICATE'         => 'http://www.example.org/predicate',
                'PREDICATE$RDFVID'  => 8663359142594985318,
                'PREDICATE$_PREFIX' => 'http://www.example.org/',
                'PREDICATE$_SUFFIX' => 'predicate',
                'PREDICATE$RDFVTYP' => 'URI',
                'PREDICATE$RDFCLOB' => null,
                'PREDICATE$RDFLTYP' => null,
                'PREDICATE$RDFLANG' => null,
                'OBJECT'            => 'Object literal.',
                'OBJECT$RDFVID'     => 4890984317608187388,
                'OBJECT$_PREFIX'    => 'Object literal.',
                'OBJECT$_SUFFIX'    => null,
                'OBJECT$RDFVTYP'    => 'LIT',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 2
            )
        );
    }

}

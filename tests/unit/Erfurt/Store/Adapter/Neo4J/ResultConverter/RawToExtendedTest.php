<?php

/**
 * Tests the result converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_ResultConverter_RawToExtendedTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Neo4J_ResultConverter_RawToExtended
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Neo4J_ResultConverter_RawToExtended();
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
        $this->assertInstanceOf('Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface', $this->converter);
    }

    /**
     * Ensures that convert() throws an exception if no array is passed
     * as input result set.
     */
    public function testThrowsExceptionIfNoArrayIsProvided()
    {
        $this->setExpectedException('Erfurt_Store_Adapter_ResultConverter_Exception');
        $this->converter->convert(new stdClass());
    }

    /**
     * Checks if convert() can handle an empty input result set.
     */
    public function testConverterCanHandleEmptySet()
    {
        $converted = $this->converter->convert(array());

        $this->assertEquals($this->createEmptyExtendedResultSet(), $converted);
    }

    /**
     * Checks if URIs are transformed correctly.
     */
    public function testConverterTransformsUrisCorrectly()
    {
        $input = array(
            array(
                'object' => 'http://example.org/object'
            )
        );

        $converted = $this->converter->convert($input);

        $expectedDefinition = array(
            'type'  => 'uri',
            'value' => 'http://example.org/object'
        );
        $this->assertEquals($this->createExtendedResultSetWith($expectedDefinition), $converted);
    }

    /**
     * Checks if simple literals are converted correctly.
     */
    public function testConverterTransformsSimpleLiteralsCorrectly()
    {
        $input = array(
            array(
                'object' => '"Hello world!"'
            )
        );

        $converted = $this->converter->convert($input);

        $expectedDefinition = array(
            'type'  => 'literal',
            'value' => 'Hello world!'
        );
        $this->assertEquals($this->createExtendedResultSetWith($expectedDefinition), $converted);
    }

    /**
     * Checks if typed literals are transformed correctly.
     */
    public function testConverterTransformsTypedLiteralsCorrectly()
    {
        $input = array(
            array(
                'object' => '"Hello world!"^^<http://www.w3.org/2001/XMLSchema#string>'
            )
        );

        $converted = $this->converter->convert($input);

        $expectedDefinition = array(
            'type'     => 'literal',
            'value'    => 'Hello world!',
            'datatype' => 'http://www.w3.org/2001/XMLSchema#string'
        );
        $this->assertEquals($this->createExtendedResultSetWith($expectedDefinition), $converted);
    }

    /**
     * Checks if literals with language information are converted correctly.
     */
    public function testConverterTransformsLiteralsWithLanguageCorrectly()
    {
        $input = array(
            array(
                'object' => '"Hello world!"@en'
            )
        );

        $converted = $this->converter->convert($input);

        $expectedDefinition = array(
            'type'  => 'literal',
            'value' => 'Hello world!',
            'lang'  => 'en'
        );
        $this->assertEquals($this->createExtendedResultSetWith($expectedDefinition), $converted);
    }

    /**
     * Returns an extended result set that contains the provided value
     * definition as "object" variable.
     *
     * @param array(string=>string) $objectDefinition
     * @return array(mixed)
     */
    protected function createExtendedResultSetWith(array $objectDefinition)
    {
        $resultSet = $this->createEmptyExtendedResultSet();
        $resultSet['head']['vars'] = array('object');
        $resultSet['results']['bindings'] = array(
            array(
                'object' => $objectDefinition
            )
        );
        return $resultSet;
    }

    /**
     * Creates an empty extended result set.
     *
     * @return array(mixed)
     */
    protected function createEmptyExtendedResultSet()
    {
        return array(
            'head' => array(
                'vars' => array()
            ),
            'results' => array(
                'bindings' => array()
            )
        );
    }

}

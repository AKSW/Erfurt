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

    }

    /**
     * Checks if convert() can handle an empty input result set.
     */
    public function testConverterCanHandleEmptySet()
    {

    }

    /**
     * Checks if URIs are transformed correctly.
     */
    public function testConverterTransformsUrisCorrectly()
    {

    }

    /**
     * Checks if simple literals are converted correctly.
     */
    public function testConverterTransformsSimpleLiteralsCorrectly()
    {

    }

    /**
     * Checks if typed literals are transformed correctly.
     */
    public function testConverterTransformsTypedLiteralsCorrectly()
    {

    }

    /**
     * Checks if literals with language information are converted correctly.
     */
    public function testConverterTransformsLiteralsWithLanguageCorrectly()
    {

    }

}

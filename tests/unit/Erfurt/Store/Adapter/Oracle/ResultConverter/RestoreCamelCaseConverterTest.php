<?php

/**
 * Tests the converter that restores variable names.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreCamelCaseConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreCamelCaseConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreCamelCaseConverter();
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

    public function testConverterChangesCharacterAfterUnderScoreToUppercase()
    {

    }

    public function testConverterDoesNotChangeVariableWithoutUnderscores()
    {

    }

    public function testConverterRestoresUnderscoresThatAreEscapedViaUnderscore()
    {
        
    }

}

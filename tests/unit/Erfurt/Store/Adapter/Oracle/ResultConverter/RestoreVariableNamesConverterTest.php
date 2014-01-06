<?php

/**
 * Tests the converter that restores variable names.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreVariableNamesConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreVariableNamesConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreVariableNamesConverter();
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
     * Checks if characters after underscores are converted to uppercase.
     */
    public function testConverterChangesCharacterAfterUnderscoreToUppercase()
    {
        $input = array(
            array('upper_case' => 42)
        );

        $converted = $this->converter->convert($input);

        $variable = $this->getVariableName($converted);
        $this->assertEquals('upperCase', $variable);

    }

    /**
     * Ensures that variable names without underscores are not changed.
     */
    public function testConverterDoesNotChangeVariableWithoutUnderscores()
    {
        $input = array(
            array('case' => 42)
        );

        $converted = $this->converter->convert($input);

        $variable = $this->getVariableName($converted);
        $this->assertEquals('case', $variable);
    }

    /**
     * Checks if escaped underscores ("__") are restored.
     */
    public function testConverterRestoresUnderscoresThatAreEscapedViaUnderscore()
    {
        $input = array(
            array('real__underscore' => 42)
        );

        $converted = $this->converter->convert($input);

        $variable = $this->getVariableName($converted);
        $this->assertEquals('real_underscore', $variable);
    }

    /**
     * Ensures that characters that are not prefixed by an underscore are converted
     * to lower case.
     */
    public function testConverterChangesCharactersThatAreNotPrefixedByUnderscoreToLowercase()
    {
        $input = array(
            array('UPPER_CASE' => 42)
        );

        $converted = $this->converter->convert($input);

        $variable = $this->getVariableName($converted);
        $this->assertEquals('upperCase', $variable);
    }

    /**
     * Returns the variable name in the converted result set.
     *
     * @param array(array(string=>mixed))|mixed $converted
     * @return string
     */
    protected function getVariableName($converted)
    {
        $this->assertInternalType('array', $converted);
        $this->assertGreaterThan(0, count($converted));
        $row = current($converted);
        $this->assertInternalType('array', $row);
        return current(array_keys($row));
    }

}

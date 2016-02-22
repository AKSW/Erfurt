<?php

/**
 * Tests the Scalar result set converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_ResultConverter_ScalarConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_ResultConverter_ScalarConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_ScalarConverter();
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
     * Ensures that convert() throws an exception if no array is passed.
     */
    public function testConvertThrowsExceptionIfNoArrayIsPassed()
    {
        $this->setExpectedException('Erfurt_Store_Adapter_ResultConverter_Exception');
        $this->converter->convert(new stdClass());
    }

    /**
     * Ensures that convert() returns null if the provided result set is empty.
     */
    public function testConvertReturnsNullIfResultSetIsEmpty()
    {
        $this->assertNull($this->converter->convert(array()));
    }

    /**
     * Checks if convert() returns the first value in the first row of the result set.
     */
    public function testConvertReturnsFirstValueInFirstRow()
    {
        $resultSet = array(
            array(
                'first'  => 42,
                'second' => 7
            ),
            array(
                'first'  => 13,
                'second' => 23
            )
        );

        $converted = $this->converter->convert($resultSet);

        $this->assertEquals(42, $converted);
    }

}

<?php

/**
 * Tests the converter that converts values in an extended result set.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverter
     */
    protected $converter = null;

    /**
     * The mocked inner converter.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $innerConverter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->innerConverter = $this->getMock('Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface');
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverter($this->innerConverter);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->converter = null;
        $this->innerConverter = null;
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
     * Checks if the inner converter is applied to each value.
     */
    public function testConverterAppliesInnerConverterToEachValue()
    {
        $this->innerConverter->expects($this->exactly(4))
                             ->method('convert')
                             ->with($this->isType('array'));

        $this->converter->convert($this->getExtendedResult());
    }

    /**
     * Checks if the value specifications in the result set are replaced by the converter specifications.
     */
    public function testConverterReplacesValueSpecificationsWithResultsFromInnerConverter()
    {
        $this->innerConverter->expects($this->any())
                             ->method('convert')
                             ->will($this->returnValue(42));

        $converted = $this->converter->convert($this->getExtendedResult());

        $this->assertInternalType('array', $converted);
        $this->assertCount(2, $converted['results']['bindings']);
        foreach ($converted['results']['bindings'] as $row) {
            /* @var $row array(string=>mixed) */
            $this->assertInternalType('array', $row);
            $this->assertEquals(42, $row['a']);
            $this->assertEquals(42, $row['b']);
        }
    }

    /**
     * Creates a SPARQL result in extended format that contains two rows
     * with two value specifications in each row.
     *
     * @return array(mixed)
     */
    protected function getExtendedResult()
    {
        return array(
            'head' => array(
                'vars' => array(
                    'a',
                    'b'
                )
            ),
            'results' => array(
                'bindings' => array(
                    array(
                        'a' => array(
                            'type' => 'uri',
                            'value' => 'http://example.org/a1'
                        ),
                        'b' => array(
                            'type' => 'uri',
                            'value' => 'http://example.org/b1'
                        )
                    ),
                    array(
                        'a' => array(
                            'type' => 'uri',
                            'value' => 'http://example.org/a2'
                        ),
                        'b' => array(
                            'type' => 'uri',
                            'value' => 'http://example.org/b2'
                        )
                    )
                )
            )
        );
    }

}

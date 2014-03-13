<?php

/**
 * Tests the ExtendedToPlain converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 02.02.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedToPlainConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_ExtendedToPlainConverter
     */
    protected $converter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_ExtendedToPlainConverter();
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
     * Checks if convert() can handle an input result set without bindings.
     */
    public function testConvertCanHandleEmptyResultSet()
    {
        $input = array(
            'head' => array(
                'vars' => array()
            ),
            'results' => array(
                'bindings' => array()
            )
        );

        $converted = $this->converter->convert($input);

        $this->assertEquals(array(), $converted);
    }

    /**
     * Checks if convert() creates the result in plain format correctly.
     */
    public function testConvertFormatsResultSetCorrectly()
    {
        $converted = $this->converter->convert($this->getExtendedResult());

        $expected = array(
            array(
                'subject'   => 'http://example.org/subject1',
                'predicate' => 'http://example.org/predicate1',
                'object'    => 'Hello world!'
            ),
            array(
                'subject'   => 'http://example.org/subject2',
                'predicate' => 'http://example.org/predicate2',
                'object'    => 'http://example.org/object'
            )
        );
        $this->assertEquals($expected, $converted);
    }

    /**
     * Creates a simple SPARQL result in extended format.
     *
     * @return array(mixed)
     */
    protected function getExtendedResult()
    {
        return array(
            'head' => array(
                'vars' => array(
                    'subject',
                    'predicate',
                    'object'
                )
            ),
            'results' => array(
                'bindings' => array(
                    array(
                        'subject' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/subject1'
                        ),
                        'predicate' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/predicate1'
                        ),
                        'object' => array(
                            'type'  => 'literal',
                            'value' => 'Hello world!'
                        )
                    ),
                    array(
                        'subject' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/subject2'
                        ),
                        'predicate' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/predicate2'
                        ),
                        'object' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/object'
                        )
                    )
                )
            )
        );
    }

}

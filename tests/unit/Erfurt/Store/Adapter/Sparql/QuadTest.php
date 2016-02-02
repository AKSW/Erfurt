<?php

/**
 * Tests the Quad implementation.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class Erfurt_Store_Adapter_Sparql_QuadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Sparql_Quad
     */
    protected $quad = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->quad = new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type' => 'uri',
                'value' => 'http://example.org/object'
            ),
            'http://example.org/graph'
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->quad = null;
        parent::tearDown();
    }

    /**
     * Checks if a Quad can also be considered a triple.
     */
    public function testQuadIsTriple()
    {
        $this->assertInstanceOf('\Erfurt_Store_Adapter_Sparql_Triple', $this->quad);
    }

    /**
     * Checks if getGraph() returns the expected value.
     */
    public function testGetGraphReturnsCorrectValue()
    {
        $this->assertEquals('http://example.org/graph', $this->quad->getGraph());
    }

    /**
     * Checks if the format() method of the quad allows the usage of the ?graph placeholder.
     */
    public function testFormatAllowsGraphPlaceholder()
    {
        $representation = $this->quad->format('?graph');

        $this->assertEquals('<' . $this->quad->getGraph() . '>', $representation);
    }

    /**
     * Checks if create() can be used to create a quad from triple information
     * plus graph URI.
     */
    public function testCreateReturnsQuadWithProvidedInformation()
    {
        $triple = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type' => 'uri',
                'value' => 'http://example.org/object'
            )
        );

        $quad = Erfurt_Store_Adapter_Sparql_Quad::create('http://example.org/graph', $triple);

        $this->assertInstanceOf('Erfurt_Store_Adapter_Sparql_Quad', $quad);
        $this->assertEquals('http://example.org/graph', $quad->getGraph());
        $this->assertEquals($triple->getSubject(), $quad->getSubject());
        $this->assertEquals($triple->getPredicate(), $quad->getPredicate());
        $this->assertEquals($triple->getObject(), $quad->getObject());
    }

}

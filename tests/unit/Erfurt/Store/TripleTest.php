<?php

/**
 * Tests the Triple class.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_TripleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Triple
     */
    protected $triple = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->triple = new Erfurt_Store_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->triple = null;
        parent::tearDown();
    }

    /**
     * Checks if getSubject() returns the correct value.
     */
    public function testGetSubjectReturnsCorrectValue()
    {
        $this->assertEquals('http://example.org/subject', $this->triple->getSubject());
    }

    /**
     * Checks if getPredicate() returns the correct value.
     */
    public function testGetPredicateReturnsCorrectValue()
    {
        $this->assertEquals('http://example.org/predicate', $this->triple->getPredicate());
    }

    /**
     * Checks if getObject() returns the correct value.
     */
    public function testGetObjectReturnsCorrectValue()
    {
        $expectedObject = array('type' => 'uri', 'value' => 'http://example.org/object');
        $this->assertEquals($expectedObject, $this->triple->getObject());
    }

    /**
     * Checks if __toString() formats a triple that contains only URIs correctly.
     */
    public function testToStringFormatsTripleWithUriObjectCorrectly()
    {
        $turtle = (string)$this->triple;

        $expected = '<http://example.org/subject> '
                  . '<http://example.org/predicate> '
                  . '<http://example.org/object> .';
        $this->assertEquals($expected, $turtle);
    }

    /**
     * Checks if __toString() formats a triple with literal object correctly.
     */
    public function testToStringFormatsTripleWithLiteralObjectCorrectly()
    {
        $triple = new Erfurt_Store_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'literal', 'value' => 'Hello world!')
        );
        $turtle = (string)$triple;

        $expected = '<http://example.org/subject> '
                  . '<http://example.org/predicate> '
                  . '"Hello world!" .';
        $this->assertEquals($expected, $turtle);
    }

    /**
     * Checks if __toString() formats blank nodes in the triple correctly.
     */
    public function testToStringFormatsBlankNodesCorrectly()
    {
        $triple = new Erfurt_Store_Triple(
            '_:subjectNode',
            'http://example.org/predicate',
            array('type' => 'bnode', 'value' => '_:objectNode')
        );
        $turtle = (string)$triple;

        $expected = '_:subjectNode '
                  . '<http://example.org/predicate> '
                  . '_:objectNode .';
        $this->assertEquals($expected, $turtle);
    }

}

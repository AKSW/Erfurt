<?php

/**
 * Tests the TriplePattern class.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_Adapter_Sparql_TriplePatternTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Sparql_TriplePattern
     */
    protected $triplePattern = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->triplePattern = new Erfurt_Store_Adapter_Sparql_TriplePattern(
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
        $this->triplePattern = null;
        parent::tearDown();
    }

    /**
     * Checks if getSubject() returns the correct value.
     */
    public function testGetSubjectReturnsCorrectValue()
    {
        $this->assertEquals('http://example.org/subject', $this->triplePattern->getSubject());
    }

    /**
     * Checks if getPredicate() returns the correct value.
     */
    public function testGetPredicateReturnsCorrectValue()
    {
        $this->assertEquals('http://example.org/predicate', $this->triplePattern->getPredicate());
    }

    /**
     * Checks if getObject() returns the correct value.
     */
    public function testGetObjectReturnsCorrectValue()
    {
        $expectedObject = array('type' => 'uri', 'value' => 'http://example.org/object');
        $this->assertEquals($expectedObject, $this->triplePattern->getObject());
    }

    /**
     * Ensures that the getters returns the expected values if null is passed
     * as subject, predicate and object.
     */
    public function testGettersReturnsCorrectValuesIfNullValuesArePassed()
    {
        $pattern = new Erfurt_Store_Adapter_Sparql_TriplePattern(null, null, null);
        $this->assertNull($pattern->getSubject(), 'Unexpected subject.');
        $this->assertNull($pattern->getPredicate(), 'Unexpected predicate.');
        $this->assertNull($pattern->getObject(), 'Unexpected object.');
    }

    /**
     * Checks if format() returns a string representation that follows the provided pattern.
     */
    public function testFormatReturnsStringDependingOnPattern()
    {
        $turtle = $this->triplePattern->format('?subject ?predicate ?object .');

        $expected = '<http://example.org/subject> '
                  . '<http://example.org/predicate> '
                  . '<http://example.org/object> .';
        $this->assertEquals($expected, $turtle);
    }

    /**
     * Ensures that format() does not replace placeholders that are not defined
     * (wild cards in the triple pattern).
     */
    public function testFormatDoesNotReplacePlaceholdersThatAreNotDefined()
    {
        $pattern = new Erfurt_Store_Adapter_Sparql_TriplePattern('http://example.org/subject', null, null);

        $representation = $pattern->format('?subject ?predicate ?object .');

        $expected = '<http://example.org/subject> '
                  . '?predicate '
                  . '?object .';
        $this->assertEquals($expected, $representation);
    }

    /**
     * Ensures that format() does not add parts of the triple that were not referenced
     * by a placeholder.
     */
    public function testFormatDoesNotIncludePartsThatAreNotReferencedByPlaceholder()
    {
        $representation = $this->triplePattern->format('Hello ?subject');

        $this->assertInternalType('string', $representation);
        $this->assertNotContains($this->triplePattern->getPredicate(), $representation);
    }

    /**
     * Checks if __toString() formats a triple that contains only URIs correctly.
     */
    public function testToStringFormatsTripleWithUriObjectCorrectly()
    {
        $turtle = (string)$this->triplePattern;

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
        $triple = new Erfurt_Store_Adapter_Sparql_TriplePattern(
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
        $triple = new Erfurt_Store_Adapter_Sparql_TriplePattern(
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

    /**
     * Checks if the __toString() method replaces null values (which
     * represent any value) by variables.
     */
    public function testToStringReplacesNullValuesByVariables()
    {
        $triple = new Erfurt_Store_Adapter_Sparql_TriplePattern(
            null,
            null,
            null
        );
        $turtle = (string)$triple;

        $expected = '?subject '
                  . '?predicate '
                  . '?object .';
        $this->assertEquals($expected, $turtle);
    }

}

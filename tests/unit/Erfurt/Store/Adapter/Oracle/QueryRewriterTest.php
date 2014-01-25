<?php

/**
 * Tests the query rewriter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 25.01.14
 */
class Erfurt_Store_Adapter_Oracle_QueryRewriterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_QueryRewriter
     */
    protected $rewriter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->rewriter = new Erfurt_Store_Adapter_Oracle_QueryRewriter();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->rewriter = null;
        parent::tearDown();
    }

    /**
     * Ensures that invalid queries are not modified by the rewriter.
     */
    public function testRewriterDoesNotModifyInvalidQueries()
    {
        $query = 'Hello world!';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertEquals($query, $rewritten);
    }

    /**
     * Checks if query variables are prefixed by the rewriter.
     */
    public function testRewriterPrefixesVariableNames()
    {
        $query = 'SELECT ?subject FROM '
               . '<http://example.org> '
               . 'WHERE { ?subject ?predicate ?object . } '
               . 'ORDER BY ASC(?object)';

        $rewritten = $this->rewriter->rewrite($query);

        // Checks if the query contains the prefixed variables...
        $this->assertContains('?'. $this->prefix('subject'), $rewritten);
        $this->assertContains('?'. $this->prefix('predicate'), $rewritten);
        $this->assertContains('?'. $this->prefix('object'), $rewritten);
        // ... and ensure that no old name is left.
        $this->assertNotContains('?subject', $rewritten);
        $this->assertNotContains('?predicate', $rewritten);
        $this->assertNotContains('?object', $rewritten);
    }

    /**
     * Ensures that the rewriter modifies variable aliases.
     */
    public function testRewriterChangesAliasNames()
    {
        $query = 'SELECT (?subject AS ?another) WHERE { ?subject ?predicate ?object . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('?'. $this->prefix('another'), $rewritten);
    }

    /**
     * Checks if the rewriter encodes upper case characters.
     */
    public function testRewriterEncodesUpperCaseCharactersInVariables()
    {
        $query = 'SELECT ?camelCase WHERE { ?camelCase ?predicate ?object . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('camel_case', $rewritten);
    }

    /**
     * Ensures that long literals in double quotes are rewritten to short
     * literals in double quotes.
     */
    public function testRewriterModifiesLongLiteralsInDoubleQuotes()
    {
        $query = 'SELECT ?subject '
               . 'WHERE { ?subject ?predicate """This is a long literal.""" . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"This is a long literal."', $rewritten);
        $this->assertNotContains('"""', $rewritten);
    }

    /**
     * Ensures that long literals in single quotes are rewritten to short
     * literals in double quotes.
     */
    public function testRewriterModifiesLongLiteralsInSingleQuotes()
    {
        $query = 'SELECT ?subject '
               . 'WHERE { ?subject ?predicate \'\'\'This is a long literal.\'\'\' . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"This is a long literal."', $rewritten);
        $this->assertNotContains('\'\'\'', $rewritten);
    }

    /**
     * Ensures that short literals in single quotes are rewritten to short
     * literals in double quotes.
     */
    public function testRewriterModifiesShortLiteralsInSingleQuotes()
    {
        $query = 'SELECT ?subject '
               . 'WHERE { ?subject ?predicate \'This is a short literal.\' . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"This is a short literal."', $rewritten);
    }

    /**
     * Ensures that the rewriter keeps short literals in double quotes.
     */
    public function testRewriterKeepsShortLiteralsInDoubleQuotes()
    {
        $query = 'SELECT ?subject '
               . 'WHERE { ?subject ?predicate "This is a short literal." . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"This is a short literal."', $rewritten);
    }

    public function testRewriterWorksIfLiteralContainsEscapedQuotes()
    {
        $query = 'SELECT ?subject '
               . 'WHERE { ?subject ?predicate """This is a \\"short\\" literal.""" . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"This is a \\"short\\" literal."', $rewritten);
    }

    /**
     * Ensures that a query that contains an IRI with quote is treated correctly.
     */
    public function testRewriterHandlesIriWithQuoteCorrectly()
    {
        $query = 'SELECT ?p ?o '
               . 'FROM <http://example.org/graph> '
               . 'WHERE { <http://example.org/iri/with/quote/x\'y> ?p ?o . }';

        $rewritten = $this->rewriter->rewrite($query);

        // The rewriter must not modify the IRI.
        $this->assertContains('<http://example.org/iri/with/quote/x\'y>', $rewritten);
    }

    /**
     * Ensures that the rewriter does not destroy any type information.
     */
    public function testRewriterPreservesTypeInformation()
    {
        $query = 'SELECT ?p ?o '
               . 'FROM <http://example.org/graph> '
               . 'WHERE { ?s ?p "abc"^^<http://www.w3.org/2001/XMLSchema#string> . }';

        $rewritten = $this->rewriter->rewrite($query);

        $this->assertContains('"abc"^^<http://www.w3.org/2001/XMLSchema#string>', $rewritten);
    }

    /**
     * Prepends the prefix to the given variable name.
     *
     * @param string $variable
     * @return string
     */
    protected function prefix($variable)
    {
        return Erfurt_Store_Adapter_Oracle_QueryRewriter::VARIABLE_PREFIX . $variable;
    }

}

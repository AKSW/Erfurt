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

    }

    /**
     * Ensures that long literals in single quotes are rewritten to short
     * literals in double quotes.
     */
    public function testRewriterModifiesLongLiteralsInSingleQuotes()
    {

    }

    /**
     * Ensures that short literals in single quotes are rewritten to short
     * literals in double quotes.
     */
    public function testRewriterModifiesShortLiteralsInSingleQuotes()
    {

    }

    /**
     * Ensures that the rewriter keeps short literals in double quotes.
     */
    public function testRewriterKeepsShortLiteralsInDoubleQuotes()
    {

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

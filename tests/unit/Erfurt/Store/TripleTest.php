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
            array('type' => 'uri', 'value' => 'http://example.org/subject')
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

    public function testGetSubjectReturnsCorrectValue()
    {

    }

    public function testGetPredicateReturnsCorrectValue()
    {

    }

    public function testGetObjectReturnsCorrectValue()
    {

    }

    public function testToStringFormatsTripleWithUriObjectCorrectly()
    {

    }

    public function testToStringFormatsTripleWithLiteralObjectCorrectly()
    {

    }

}

<?php

/**
 * Tests the triple iterator.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_TripleIteratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_TripleIterator
     */
    protected $iterator = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $statements = array(
            'http://example.org/subject1' => array(
                'http://example.org/predicate1_1' => array(
                    array(
                        'type' => 'literal',
                        'value' => 'Hello world.'
                    )
                ),
                'http://example.org/predicate1_2' => array(
                    array(
                        'type' => 'uri',
                        'value' => 'http://example.org/object1_2_1'
                    ),
                    array(
                        'type' => 'uri',
                        'value' => 'http://example.org/object1_2_2'
                    )
                )
            ),
            'http://example.org/subject2' => array(
                'http://example.org/predicate2_1' => array(
                    array(
                        'type' => 'uri',
                        'value' => 'http://example.org/object2_1_1'
                    ),
                )
            )
       );
       $this->iterator = new Erfurt_Store_TripleIterator($statements);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->iterator = null;
        parent::tearDown();
    }

    /**
     * Checks if the iterator is (somehow) traversable.
     */
    public function testIteratorIsTraversable()
    {

    }

    /**
     * Checks if the iterator returns the correct number of triples.
     */
    public function testIteratorContainsCorrectTriples()
    {

    }

    /**
     * Ensures that the iterator returns the correct triple data.
     */
    public function testIteratorReturnsCorrectNumberOfTriples()
    {

    }

}

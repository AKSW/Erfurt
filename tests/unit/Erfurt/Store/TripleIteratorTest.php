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
        $this->assertInstanceOf('Traversable', $this->iterator);
    }

    /**
     * Checks if the iterator returns the correct number of triples.
     */
    public function testIteratorContainsCorrectTriples()
    {
        $numberOfTriples = iterator_count($this->iterator);

        $this->assertEquals(4, $numberOfTriples);
    }

    /**
     * Ensures that the iterator returns the correct triple data.
     */
    public function testIteratorReturnsCorrectNumberOfTriples()
    {
        $expectedTriples = array(
            new Erfurt_Store_Triple(
                'http://example.org/subject1',
                'http://example.org/predicate1_1',
                array(
                    'type'  => 'literal',
                    'value' => 'Hello world.'
                )
            ),
            new Erfurt_Store_Triple(
                'http://example.org/subject1',
                'http://example.org/predicate1_2',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object1_2_1'
                )
            ),
            new Erfurt_Store_Triple(
                'http://example.org/subject1',
                'http://example.org/predicate1_2',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object1_2_2'
                )
            ),
            new Erfurt_Store_Triple(
                'http://example.org/subject2',
                'http://example.org/predicate2_1',
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object2_1_1'
                )
            )
        );

        $triplesAsTurtle = array_map(function ($triple) {
            return (string)$triple;
        }, iterator_to_array($this->iterator));

        foreach ($expectedTriples as $triple) {
            /* @var $triple \Erfurt_Store_Triple */
            $this->assertContains((string)$triple, $triplesAsTurtle);
        }
    }

    /**
     * Checks if it is possible to iterate multiple times over the triples.
     */
    public function testIteratorCanBeReUsed()
    {
        // Use the number of items as checksum:
        $numberInFirstIteration  = iterator_count($this->iterator);
        $numberInSecondIteration = iterator_count($this->iterator);
        $this->assertEquals($numberInFirstIteration, $numberInSecondIteration);
    }

    /**
     * Ensures that the iterator can be used with an empty statements list.
     */
    public function testIteratorWorksWithEmptyStatementsArray()
    {
        $iterator = new Erfurt_Store_TripleIterator(array());

        $this->assertCount(0, $iterator);
    }

}

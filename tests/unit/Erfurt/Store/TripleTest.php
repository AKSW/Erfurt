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
     * Checks if the triple constructor rejects null as subject value.
     */
    public function testTripleRejectsNullAsSubjectValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new Erfurt_Store_Triple(
            null,
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
    }

    /**
     * Checks if the triple constructor rejects null as predicate value.
     */
    public function testTripleRejectsNullAsPredicate()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new Erfurt_Store_Triple(
            'http://example.org/subject',
            null,
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
    }

    /**
     * Checks if the triple constructor rejects null as object value.
     */
    public function testTripleRejectsNullAsObject()
    {
        // Expect an Error as a type hint is used.
        $this->setExpectedException('\PHPUnit_Framework_Error');
        new Erfurt_Store_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            null
        );
    }

    /**
     * Ensures that the triple constructor accepts a set of concrete values.
     */
    public function testTripleAcceptsConcreteValues()
    {
        $this->setExpectedException(null);
        new Erfurt_Store_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
    }

}

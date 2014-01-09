<?php

/**
 * Represents a triple that contains subject, predicate and object.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.01.14
 */
class Erfurt_Store_Triple
{

    /**
     * Creates a triple that contains the given components.
     *
     * @param string $subject
     * @param string $predicate
     * @param array(string=>string) $object
     */
    public function __construct($subject, $predicate, array $object)
    {

    }

    /**
     * Returns the subject.
     *
     * @return string
     */
    public function getSubject()
    {

    }

    /**
     * Returns the predicate.
     *
     * @return string
     */
    public function getPredicate()
    {

    }

    /**
     * Returns the object definition.
     *
     * @return array(string=>string)
     */
    public function getObject()
    {

    }

    /**
     * Returns the triple in Turtle format.
     *
     * Example:
     *
     *     $triple = new Erfurt_Store_Triple(
     *         'http://example.org/subject',
     *         'http://example.org/predicate',
     *         array('type' => 'uri', 'value' => 'http://example.org/object')
     *     );
     *     // Generates:
     *     // <http://example.org/subject> <http://example.org/predicate> <http://example.org/object> .
     *     $turtle = (string)$triple;
     *
     * @return string
     */
    public function __toString()
    {

    }

}

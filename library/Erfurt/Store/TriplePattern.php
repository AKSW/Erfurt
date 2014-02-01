<?php

/**
 * Represents a triple pattern.
 *
 * A triple pattern may contain concrete values for subject, predicate and object,
 * but it also allows null values, which indicate that every value is allowed at
 * that position.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.02.14
 */
class Erfurt_Store_TriplePattern
{

    /**
     * The subject URI or blank node identifier.
     *
     * Null if any value is allowed.
     *
     * @var string|null
     */
    protected $subject = null;

    /**
     * The predicate URI.
     *
     * Null if any value is allowed.
     *
     * @var string|null
     */
    protected $predicate = null;

    /**
     * The object definition (URI, blank node or literal).
     *
     * Null if any value is allowed.
     *
     * @var array(string=>string)|null
     */
    protected $object = array();

    /**
     * Creates a triple that contains the given components.
     *
     * Null can be passed to indicate that every value is allowed
     * at that position.
     *
     * @param string|null $subject
     * @param string|null $predicate
     * @param array(string=>string)|null $object
     */
    public function __construct($subject = null, $predicate = null, array $object = null)
    {
        $this->subject   = $subject;
        $this->predicate = $predicate;
        $this->object    = $object;
    }

    /**
     * Returns the subject.
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns the predicate.
     *
     * @return string|null
     */
    public function getPredicate()
    {
        return $this->predicate;
    }

    /**
     * Returns the object definition.
     *
     * @return array(string=>string)|null
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Returns the triple in a Turtle-like format.
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
     * Null placeholders will be represented as variable identifiers, for example "?subject".
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->object['type'] === 'uri') {
            $object = '<' . $this->object['value'] . '>';
        } else if ($this->object['type'] === 'bnode') {
            $object = $this->object['value'];
        } else {
            $object = Erfurt_Utils::buildLiteralString(
                $this->object['value'],
                isset($this->object['datatype']) ? $this->object['datatype'] : null,
                isset($this->object['lang']) ? $this->object['lang'] : null
            );
        }
        if (strpos($this->subject, '_:') === 0) {
            // Subject is a blank node.
            $subject = $this->subject;
        } else {
            $subject = '<' . $this->subject . '>';
        }
        $template = '%s <%s> %s .';
        return sprintf($template, $subject, $this->predicate, $object);
    }
}

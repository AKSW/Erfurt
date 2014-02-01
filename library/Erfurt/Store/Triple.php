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
     * The subject URI.
     *
     * @var string
     */
    protected $subject = null;

    /**
     * The predicate URI.
     *
     * @var string
     */
    protected $predicate = null;

    /**
     * The object definition.
     *
     * @var array(string=>string)
     */
    protected $object = array();

    /**
     * Creates a triple that contains the given components.
     *
     * @param string $subject
     * @param string $predicate
     * @param array(string=>string) $object
     */
    public function __construct($subject, $predicate, array $object)
    {
        $this->subject   = $subject;
        $this->predicate = $predicate;
        $this->object    = $object;
    }

    /**
     * Returns the subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns the predicate.
     *
     * @return string
     */
    public function getPredicate()
    {
        return $this->predicate;
    }

    /**
     * Returns the object definition.
     *
     * @return array(string=>string)
     */
    public function getObject()
    {
        return $this->object;
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
        if ($this->object['type'] === 'uri') {
            $object = '<' . $this->object['value'] . '>';
        } else {
            $object = Erfurt_Utils::buildLiteralString(
                $this->object['value'],
                isset($this->object['datatype']) ? $this->object['datatype'] : null,
                isset($this->object['lang']) ? $this->object['lang'] : null
            );
        }
        $template = '<%s> <%s> %s .';
        return sprintf($template, $this->subject, $this->predicate, $object);
    }

}

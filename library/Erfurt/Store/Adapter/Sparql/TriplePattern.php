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
class Erfurt_Store_Adapter_Sparql_TriplePattern
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
     * Returns a string representation of the triple.
     *
     * The provided pattern defines how this representation looks like
     * and may contain placeholders like "?subject" or "?object".
     *
     * Example:
     *
     *     // Creates a representation that can be used as pattern in a SPARQL query.
     *     $representation = $pattern->format('?subject ?predicate ?object .');
     *
     * @param string $pattern
     * @return string The string representation of the triple.
     */
    public function format($pattern)
    {
        '';
    }

    /**
     * Returns the triple in a Turtle-like format.
     *
     * Example:
     *
     *     $triple = new Erfurt_Store_Adapter_Sparql_TriplePattern(
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
        if ($this->subject === null) {
            $subject = $this->formatValue(array('type' => 'variable', 'value' => '?subject'));
        } else if (strpos($this->subject, '_:') === 0) {
            // Subject is a blank node.
            $subject = $this->formatValue(array('type' => 'bnode', 'value' => $this->subject));
        } else {
            $subject = $this->formatValue(array('type' => 'uri', 'value' => $this->subject));
        }
        if ($this->predicate === null) {
            $predicate = $this->formatValue(array('type' => 'variable', 'value' => '?predicate'));
        } else {
            $predicate = $this->formatValue(array('type' => 'uri', 'value' => $this->predicate));
        }
        if ($this->object === null) {
            $object = $this->formatValue(array('type' => 'variable', 'value' => '?object'));
        } else {
            $object = $this->formatValue($this->object);
        }
        return sprintf('%s %s %s .', $subject, $predicate, $object);
    }

    /**
     * Returns a list of placeholders (keys) and their corresponding values.
     *
     * This list is used by the format() method.
     *
     * @return array(string=>string)
     */
    protected function getPlaceholderValues()
    {

    }

    /**
     * Uses the provided value specification to create a string representation.
     *
     * The specification must provide a type as well as a value entry.
     *
     * @param array(string=>string) $valueSpecification
     * @return string
     */
    protected function formatValue(array $valueSpecification)
    {
        switch ($valueSpecification['type']) {
            case 'bnode':
            case 'variable':
                return $valueSpecification['value'];
            case 'uri':
                return '<' . $valueSpecification['value'] . '>';
            case 'literal':
            default:
                return Erfurt_Utils::buildLiteralString(
                    $valueSpecification['value'],
                    isset($valueSpecification['datatype']) ? $valueSpecification['datatype'] : null,
                    isset($valueSpecification['lang']) ? $valueSpecification['lang'] : null
                );
        }
    }
}

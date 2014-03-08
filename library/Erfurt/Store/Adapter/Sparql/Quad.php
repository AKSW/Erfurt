<?php

/**
 * Represents a Quad, which is a triple plus the graph it is assigned to.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class Erfurt_Store_Adapter_Sparql_Quad extends Erfurt_Store_Adapter_Sparql_Triple
{

    /**
     * The graph URI.
     *
     * @var string
     */
    protected $graph = null;

    /**
     * Creates quad from triple and graph information.
     *
     * @param string $graph
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     * @return Erfurt_Store_Adapter_Sparql_Quad
     */
    public static function create($graph, Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        return new Erfurt_Store_Adapter_Sparql_Quad(
            $triple->getSubject(),
            $triple->getPredicate(),
            $triple->getObject(),
            $graph
        );
    }

    /**
     * Creates a quad that contains the given components.
     *
     * @param string $subject
     * @param string $predicate
     * @param array(string=>string) $object
     * @param string $graph URI of the graph that the quad belongs to.
     * @throws \InvalidArgumentException If a placeholder is provided.
     */
    public function __construct($subject, $predicate, array $object, $graph)
    {
        parent::__construct($subject, $predicate, $object, $graph);
        $this->graph = $graph;
    }

    /**
     * Returns the graph URI.
     *
     * @return string
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * Returns a list of placeholders (keys) and their corresponding values.
     *
     * In addition to normal triples, the ?graph placeholder is provided.
     *
     * @return array(string=>string)
     */
    protected function getPlaceholderValues()
    {
        $placeholders = parent::getPlaceholderValues();
        $placeholders['?graph'] = $this->formatValue(array('type' => 'uri', 'value' => $this->getGraph()));
        return $placeholders;
    }

}

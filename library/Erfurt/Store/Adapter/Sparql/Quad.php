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
     * Creates quad from triple and graph information.
     *
     * @param string $graph
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     * @return Erfurt_Store_Adapter_Sparql_Quad
     */
    public static function create($graph, Erfurt_Store_Adapter_Sparql_Triple $triple)
    {

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

    }

    /**
     * Returns the graph URI.
     *
     * @return string
     */
    public function getGraph()
    {

    }

}

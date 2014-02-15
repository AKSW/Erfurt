<?php

/**
 * Represents a Quad, which is a triple plus the graph it is assigned to.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class Erfurt_Store_Adapter_Sparql_Quad
{
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

<?php

/**
 * Converts a raw Neo4J result set into extended format.
 *
 * The raw format that is returned by the Neo4J SPARQL plugin is a simple
 * table that contains literals as RDF terms. URIs are not enclosed by
 * braces ("<", ">").
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_ResultConverter_RawToExtended
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the provided result set.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        // TODO: Implement convert() method.
    }

}

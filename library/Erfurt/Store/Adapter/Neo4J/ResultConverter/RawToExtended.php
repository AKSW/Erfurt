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
        if (!is_array($resultSet)) {
            throw new Erfurt_Store_Adapter_ResultConverter_Exception('Expected array as input result set.');
        }
        $template = array(
            'head' => array(
                'vars' => array()
            ),
            'results' => array(
                'bindings' => array()
            )
        );
        if (count($resultSet) === 0) {
            return $template;
        }
        $template['head']['vars'] = array_keys($resultSet[0]);
        $template['results']['bindings'] = $this->toBindings($resultSet);
        return $template;
    }

    /**
     * Converts the provided result set into a list of bindings
     * that is compatible with an extended result.
     *
     * @param array(array(string=>string)) $resultSet
     * @return array(array(string=>array(string=>mixed)))
     */
    protected function toBindings(array $resultSet)
    {
        $bindings = array();
        foreach ($resultSet as $row) {
            /* @var $row array(string=>string) */
            $binding = array();
            foreach ($row as $name => $value) {
                /* @var $name string */
                /* @var $value string */
                $binding[$name] = $this->toValueDefinition($value);
            }
            $bindings[] = $binding;
        }
        return $bindings;
    }

    /**
     * Parses the provided value and returns a value definition.
     *
     * @param string $term
     * @return array(string=>string)
     */
    protected function toValueDefinition($term)
    {
        if (strpos($term, '"') !== 0) {
            // No literal.
            return array(
                'type'  => 'uri',
                'value' => $term
            );
        }
        $closingQuote = strrpos($term, '"');
        $definition = array(
            'type' => 'literal',
            'value' => substr($term, 1, $closingQuote - 1)
        );
        $trailingPart = substr($term, $closingQuote + 1);
        if (strpos($trailingPart, '@') === 0) {
            // Language provided.
            $definition['lang'] = ltrim($trailingPart, '@');
        } else if (strpos($trailingPart, '^^') === 0) {
            // Literal type provided.
            $definition['datatype'] = trim($trailingPart, '^<>');
        }
        return $definition;
    }

}

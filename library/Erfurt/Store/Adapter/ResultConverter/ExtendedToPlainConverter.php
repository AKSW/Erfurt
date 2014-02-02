<?php

/**
 * Result set converter that converts from extended to plain format.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 02.02.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedToPlainConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts a result set from extended to plain format.
     *
     * @param array(mixed) $resultSet
     * @return array(array(string=>string))
     */
    public function convert($resultSet)
    {
        $plain = array();
        $row   = 0;
        foreach ($resultSet['results']['bindings'] as $binding) {
            /* @var $binding array(string=>array(string=>string)) */
            foreach ($binding as $name => $definition) {
                /* @var $name string */
                /* @var $definition array(string=>mixed) */
                $plain[$row][$name] = $definition['value'];
            }
            $row++;
        }
        return $plain;
    }

}

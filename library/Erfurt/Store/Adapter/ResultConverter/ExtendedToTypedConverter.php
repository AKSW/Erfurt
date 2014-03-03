<?php

/**
 * Converts values in the bindings of an extended result set to native PHP types.
 *
 * This means, that for example literals with data type <http://www.w3.org/2001/XMLSchema#integer>
 * are casted to PHP integer values.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedToTypedConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts literals in provided result set if necessary.
     *
     * The converted result set has still the structure of an extended query result set.
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

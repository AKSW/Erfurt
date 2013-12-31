<?php

/**
 * Accepts a raw Oracle result set and converts the values in to native PHP types
 * according to their type definition.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RawToTypedConverter
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{
    /**
     * Converts the values in the given result set into native PHP types.
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

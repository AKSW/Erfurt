<?php

/**
 * Converts an raw Oracle result set into a simple form, which contains all
 * variables in lower case and does not provide additional information such
 * as the type of a variable.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RawToSimpleConverter
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the provided result set.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     */
    public function convert($resultSet)
    {
        // TODO: Implement convert() method.
    }

}

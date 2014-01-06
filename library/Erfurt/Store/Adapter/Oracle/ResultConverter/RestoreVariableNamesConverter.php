<?php

/**
 * Converter that restores the uppercase characters in variable names.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreVariableNamesConverter
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{
    /**
     * Restores the uppercase characters in variable names.
     *
     * @param array(array(string=>string)) $resultSet
     * @return array(array(string=>string))
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        // TODO: Implement convert() method.
    }

}

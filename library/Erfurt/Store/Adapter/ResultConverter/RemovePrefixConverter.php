<?php

/**
 * Converter that removes a prefix from all variables in a row (if it exists).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 05.01.14
 */
class  Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter
    implements  Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Creates the converter.
     *
     * @param string $prefix The prefix that will be removed.
     */
    public function __construct($prefix)
    {

    }

    /**
     * Removes prefixes from row variables.
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

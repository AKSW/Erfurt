<?php

/**
 * Converts values in the bindings of an extended result set.
 *
 * This converter applies another converter that is passed to the constructor to
 * each value specification in an extended result set.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Creates the converter.
     *
     * @param Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface $valueConverter
     */
    public function __construct(Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface $valueConverter)
    {

    }

    /**
     * Converts value specifications in the provided result.
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

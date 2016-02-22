<?php

/**
 * Null object implementation of a result set converter that does not change the provided data.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.12.13
 */
class Erfurt_Store_Adapter_ResultConverter_NullConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Simply returns the unmodified result set.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     */
    public function convert($resultSet)
    {
        return $resultSet;
    }

}

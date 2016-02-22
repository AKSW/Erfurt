<?php

/**
 * Converts a result set into a JSON string.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 19.01.14
 */
class Erfurt_Store_Adapter_ResultConverter_ToJsonConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the given result set into JSON.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return string
     */
    public function convert($resultSet)
    {
        return Zend_Json::encode($resultSet);
    }

}

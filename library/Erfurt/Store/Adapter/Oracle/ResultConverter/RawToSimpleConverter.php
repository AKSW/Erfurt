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
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If no array is passed.
     */
    public function convert($resultSet)
    {
        if (!is_array($resultSet)) {
            $message = 'Expected array for conversion.';
            throw new Erfurt_Store_Adapter_ResultConverter_Exception($message);
        }
        return array_map(function (array $row) {
            foreach (array_keys($row) as $key) {
                // Remove additional columns that contain meta data,
                // which is provided by Oracle.
                if (strpos($key, '$') !== false) {
                    unset($row[$key]);
                }
            }
            return array_change_key_case($row, CASE_LOWER);
        }, $resultSet);
    }

}

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
     * @param array(array(string=>string)) $resultSet
     * @return array(array(string=>mixed))
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        if (!is_array($resultSet)) {
            $message = 'Expected array for conversion.';
            throw new Erfurt_Store_Adapter_ResultConverter_Exception($message);
        }
        $variables = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::getVariables($resultSet);
        foreach ($resultSet as $index => $row) {
            /* @var $row array(string=>string) */
            foreach ($variables as $variable) {
                /* @var $variable string */
                if ($row[$variable . '$RDFCLOB'] !== null) {
                    $value = $row[$variable . '$RDFCLOB'];
                } else {
                    $value =  $row[$variable];
                }
                $resultSet[$index][$variable] = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType(
                    $value,
                    $row[$variable . '$RDFLTYP']
                );
            }
        }
        return $resultSet;
    }

}

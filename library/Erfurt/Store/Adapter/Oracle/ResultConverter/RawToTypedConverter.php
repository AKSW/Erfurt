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
        $variables = $this->getVariables($resultSet);
        foreach ($resultSet as $index => $row) {
            /* @var $row array(string=>string) */
            foreach ($variables as $variable) {
                /* @var $variable string */
                $resultSet[$index][$variable] = $this->convertToType($row[$variable], $row[$variable . '$RDFLTYP']);
            }
        }
        return $resultSet;
    }

    /**
     * Converts the provided value into a native PHP type.
     *
     * The provided data type URI determines which conversion is used.
     *
     * Example:
     *
     *     // Returns the integer value 42:
     *     $value = $this->convertToType('42', 'http://www.w3.org/2001/XMLSchema#int');
     *
     * @param string $value
     * @param string|null $dataType
     * @return mixed
     */
    protected function convertToType($value, $dataType)
    {
        switch ($dataType) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                return ($value === 'true');
            case 'http://www.w3.org/2001/XMLSchema#integer':
            case 'http://www.w3.org/2001/XMLSchema#int':
                return (int)$value;
            case 'http://www.w3.org/2001/XMLSchema#decimal':
            case 'http://www.w3.org/2001/XMLSchema#float':
            case 'http://www.w3.org/2001/XMLSchema#double':
                return (double)$value;
            case 'http://www.w3.org/2001/XMLSchema#string':
            case null:
            default:
                return $value;
        }
    }

    /**
     * Returns an array with the names of the variables that occur
     * in the provided result set.
     *
     * The variable names are returned as they are in the result set,
     * which means that they are in upper case.
     *
     * @param array(array(string=>string|null)) $resultSet
     * @return array(string)
     */
    protected function getVariables(array $resultSet)
    {
        if (count($resultSet) === 0) {
            // Result set is empty, no variables are bound.
            return array();
        }
        $firstRow = current($resultSet);
        $variables = array();
        foreach (array_keys($firstRow) as $column) {
            /* @var $column string */
            if (strpos($column, '$') === false) {
                // This is not a meta data, but a variable column.
                $variables[] = $column;
            }
        }
        return $variables;
    }

}

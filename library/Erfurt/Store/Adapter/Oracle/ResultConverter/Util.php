<?php

/**
 * Contains several helper methods for working with Oracle result sets.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_Util
{

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
    public static function getVariables(array $resultSet)
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

    /**
     * Converts the provided value into a native PHP type.
     *
     * The provided data type URI determines which conversion is used.
     * The existing data types are documented at {@link http://www.w3.org/TR/xmlschema-2/#built-in-datatypes}.
     * Currently only a subset of these is supported by this method.
     *
     * Example:
     *
     *     // Returns the integer value 42:
     *     $dataType = 'http://www.w3.org/2001/XMLSchema#int';
     *     $value    = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType('42', $dataType);
     *
     * @param string $value
     * @param string|null $dataType
     * @return mixed
     */
    public static function convertToType($value, $dataType)
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

}

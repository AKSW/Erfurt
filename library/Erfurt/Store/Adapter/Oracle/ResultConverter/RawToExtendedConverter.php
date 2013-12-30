<?php

/**
 * Converts a raw Oracle result set into the extended format.
 *
 * The extended format contains additional information about
 * the variable types.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RawToExtendedConverter
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the provided result set.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        if (!is_array($resultSet)) {
            $message = 'Expected array for conversion.';
            throw new Erfurt_Store_Adapter_ResultConverter_Exception($message);
        }
        $variables = $this->getVariables($resultSet);
        $bindings  = array();
        foreach ($resultSet as $row) {
            /* @var $row array(string=>string|null) */
            $binding = array();
            foreach ($variables as $variable) {
                /* @var $variable string */
                $binding[strtolower($variable)] = $this->extractVariableInformation($variable, $row);
            }
            $bindings[] = $binding;
        }
        $extendedResult = array(
            'head' => array(
                'vars' => array_map('strtolower', $variables)
            ),
            'results' => array(
                'bindings' => $bindings
            )
        );
        return $extendedResult;
    }

    /**
     * Extracts information about the provided variable from the given raw result set row.
     *
     * @param string $variable
     * @param array(string=>string|null) $row
     * @return array(string=>string)
     */
    protected function extractVariableInformation($variable, array $row)
    {
        return array(
            'value' => $row[$variable],
            'type'  => $this->toTypeIdentifier($row[$variable . '$RDFVTYP'])
        );
    }

    /**
     * Converts the provided Oracle variable type identifier into the
     * corresponding identifier that is used in Erfurt.
     *
     * @param string $oracleTypeInformation
     * @return string
     */
    protected function toTypeIdentifier($oracleTypeInformation)
    {
        switch ($oracleTypeInformation) {
            case 'LIT':
                return 'literal';
            case 'URI':
            default:
                return strtolower($oracleTypeInformation);
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

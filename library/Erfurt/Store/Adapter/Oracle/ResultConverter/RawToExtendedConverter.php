<?php

/**
 * Converts a raw Oracle result set into the extended format.
 *
 * The extended format contains additional information about
 * the variable types.
 *
 * The extended format has the following structure:
 *
 *     array(
 *         'head' => array(
 *             'vars' => array(
 *                 // Contains the names of all variables that occur in the result set.
 *                 'variable1',
 *                 'variable2'
 *             )
 *         )
 *         'results' => array(
 *             'bindings' => array(
 *                 // Contains one entry for each result set row.
 *                 // Each entry contains the variable name as key and a set
 *                 // of additional information as value:
 *                 array(
 *                     'variable1' => array(
 *                         'value' => 'http://example.org',
 *                         'type'  => 'uri'
 *                     ),
 *                     'variable2' => array(
 *                         'value' => 'Hello world!',
 *                         'type'  => 'literal'
 *                     )
 *                 )
 *             )
 *         )
 *     )
 *
 * If available the language or the data type will be added to literal values, for example:
 *
 *     array(
 *         'value'    => 'Hello world!',
 *         'type'     => 'literal',
 *         'datatype' => 'http://www.w3.org/2001/XMLSchema#string'
 *     )
 *
 *     array(
 *         'value' => 'Hello world!',
 *         'type'  => 'literal',
 *         'lang'  => 'en'
 *     )
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
        $variables = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::getVariables($resultSet);
        $bindings  = array();
        foreach ($resultSet as $row) {
            /* @var $row array(string=>string|null) */
            $binding = array();
            foreach ($variables as $variable) {
                /* @var $variable string */
                $binding[$this->decodeVariableName($variable)] = $this->extractVariableInformation($variable, $row);
            }
            $bindings[] = $binding;
        }
        $extendedResult = array(
            'head' => array(
                'vars' => array_map(array($this, 'decodeVariableName'), $variables)
            ),
            'results' => array(
                'bindings' => $bindings
            )
        );
        return $extendedResult;
    }

    /**
     * Decodes the given variable name and restores the original upper/lower case characters.
     *
     * @param string $variable
     * @return string
     */
    protected function decodeVariableName($variable)
    {
        return Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($variable);
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
        $data = array(
            'value' => $row[$variable],
            'type'  => $this->toTypeIdentifier($row[$variable . '$RDFVTYP'])
        );
        if ($row[$variable . '$RDFLANG'] !== null) {
            $data['lang'] = $row[$variable . '$RDFLANG'];
        }
        if ($row[$variable . '$RDFLTYP'] !== null) {
            $data['datatype'] = $row[$variable . '$RDFLTYP'];
        }
        return $data;
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

}

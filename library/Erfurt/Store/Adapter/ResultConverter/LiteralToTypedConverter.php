<?php

/**
 * Accepts a value specification and converts literal value to their native PHP
 * types (if possible).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Accepts a value specification and returns the same specification
     * with the value casted to the PHP type that is associated with
     * defined literal data type.
     *
     * Non literal specification will not be changed.
     *
     * @param array(string=>string) $valueSpecification
     * @return array(string=>string) The specification with typed literal value.
     */
    public function convert($valueSpecification)
    {
        if (!$this->isLiteral($valueSpecification)) {
            return $valueSpecification;
        }
        $dataType = isset($valueSpecification['datatype']) ? $valueSpecification['datatype'] : null;
        $typed    = $this->convertToType($valueSpecification['value'], $dataType);
        $valueSpecification['value'] = $typed;
        return $valueSpecification;
    }

    /**
     * Checks if the given value specification contains a literal.
     *
     * @param array(string=>string) $valueSpecification
     * @return boolean
     */
    protected function isLiteral($valueSpecification)
    {
        return $valueSpecification['type'] === 'literal';
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
     *     $value    = $this->convertToType('42', $dataType);
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
                return (string)$value;
        }
    }

}

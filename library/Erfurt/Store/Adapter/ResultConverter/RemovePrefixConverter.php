<?php

/**
 * Converter that removes a prefix from all variables in a row (if it exists).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 05.01.14
 */
class  Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter
    implements  Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * The prefix that will be removed.
     *
     * @var string
     */
    protected $prefix = null;

    /**
     * Creates the converter.
     *
     * @param string $prefix The prefix that will be removed.
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Removes prefixes from row variables.
     *
     * @param array(array(string=>string)) $resultSet
     * @return array(array(string=>string))
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        if (!is_array($resultSet)) {
            $message = 'Expected array for conversion.';
            throw new Erfurt_Store_Adapter_ResultConverter_Exception($message);
        }
        foreach ($resultSet as $index => $row) {
            /* @var $row array(string=>string) */
            foreach ($row as $name => $value) {
                if ($this->startsWithPrefix($name)) {
                    $withoutPrefix = substr($name, strlen($this->prefix));
                    $resultSet[$index][$withoutPrefix] = $value;
                    unset($resultSet[$index][$name]);
                }
            }
        }
        return $resultSet;
    }

    /**
     * Checks if the provided value starts with the prefix.
     *
     * @param string $value
     * @return boolean
     */
    protected function startsWithPrefix($value)
    {
        return strpos($value, $this->prefix) === 0;
    }

}

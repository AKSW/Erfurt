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
        return array_map(array($this, 'removePrefixFromKeys'), $resultSet);
    }

    /**
     * Removes the prefix from the keys in the given array.
     *
     * @param array(string=>mixed) $row
     * @return array(string=>mixed)
     */
    protected function removePrefixFromKeys(array $row)
    {
        foreach (array_keys($row) as $key) {
            /* @var $key string */
            if ($this->startsWithPrefix($key)) {
                $withoutPrefix = substr($key, strlen($this->prefix));
                $row[$withoutPrefix] = $row[$key];
                unset($row[$key]);
            }
        }
        return $row;
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

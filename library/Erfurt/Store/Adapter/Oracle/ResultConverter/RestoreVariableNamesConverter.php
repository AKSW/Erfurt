<?php

/**
 * Converter that restores the uppercase characters in variable names.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_RestoreVariableNamesConverter
    implements Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{
    /**
     * Restores the uppercase characters in variable names.
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
            /* @var $row array(string=>mixed) */
            foreach ($row as $name => $value) {
                /* @var $name string */
                /* @var $value mixed */
                $newName = $this->convertName($name);
                if ($newName !== $name) {
                    // The name changed.
                    $resultSet[$index][$newName] = $value;
                    unset($resultSet[$index][$name]);
                }
            }
        }
        return $resultSet;
    }

    /**
     * Restores upper case characters in the provided variable name.
     *
     * @param string $name
     * @return string
     */
    protected function convertName($name)
    {
        $name = strtolower($name);
        return preg_replace_callback('/_([a-z_])/', function (array $match) {
            return strtoupper($match[1]);
        }, $name);
    }

}

<?php
/**
 *   Value class that holds some arbitrary value
 *   and a datatype.
 *   Objects of this class can transparently be used in strings since
 *   its __toString() returns the value.
 */
class Erfurt_Sparql_EngineDb_FilterGeneratorValue
{
    public $value = null;
    public $type  = null;

    public function __construct($value, $type = null)
    {
        $this->value = $value;
        $this->type  = $type;
    }

    public function __toString()
    {
        return $this->value;
    }
}

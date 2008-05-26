<?php
/**
*   Object representation of a SPARQL variable.
*   @license http://www.gnu.org/licenses/lgpl.html LGPL
*/
class Erfurt_Sparql_Variable
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }



    public function __toString()
    {
        return $this->name;
    }



    /**
    *   Checks if the given subject/predicate/object
    *   is a variable name.
    *
    *   @return boolean
    */
    public static function isVariable($bject)
    {
        return is_string($bject) && strlen($bject) >= 2
             && ($bject[0] == '?' || $bject[0] == '$');
    }//public static function isVariable($bject)

}
?>
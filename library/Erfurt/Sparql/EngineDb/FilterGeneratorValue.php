<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Value class that holds some arbitrary value and a datatype.
 * Objects of this class can transparently be used in strings since
 * its __toString() returns the value.
 *
 * @package Erfurt_Sparql_EngineDb
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

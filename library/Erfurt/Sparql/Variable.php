<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Object representation of a SPARQL variable.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package Erfurt_Sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
class Erfurt_Sparql_Variable
{
    protected $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function __toString()
    {
        return $this->_name;
    }

    /**
     *   Checks if the given subject/predicate/object
     *   is a variable name.
     *
     *   @return boolean
     */
    public static function isVariable($bject)
    {
        return (is_string($bject) && (strlen($bject) >= 2) && (($bject[0] == '?') || ($bject[0] == '$')));
    }
}

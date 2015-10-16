<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */



/**
 * Erfurt Sparql Query2 - Collection
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_Collection extends Erfurt_Sparql_Query2_ObjectList  implements Erfurt_Sparql_Query2_TriplesNode
{
    /**
     * @param array array of Erfurt_Sparql_Query2_GraphNode
     */
    public function __construct ($objects) {
        parent::__construct($objects);
    }

    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "(obj1, obj2, obj3)"
     * @return string
     */
    public function getSparql() {
        return '('.parent::getSparql().')';
    }
    
    public function __toString() {    
        return $this->getSparql();
    }
}
?>

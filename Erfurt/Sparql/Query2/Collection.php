<?php

require_once 'ObjectList.php';

/**
 * Erfurt Sparql Query2 - Collection
 * 
 * @package   erfurt
 * @subpackage query2 
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Collection.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
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

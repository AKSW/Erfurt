<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlankNodePropertyList
 *
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 */
class Erfurt_Sparql_Query2_BlankNodePropertyList implements Erfurt_Sparql_Query2_TriplesNode {
    protected $propertyList;

    function __construct(Erfurt_Sparql_Query2_PropertyList $propertyList) {
        if($propertyList->isEmpty()){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_BlankNodePropertyList::__construct must not be an empty PropertyList', E_USER_ERROR);
        }
        $this->propertyList = $propertyList;
    }

    public function getSparql(){
        return '[' . $this->propertyList . ']';
    }
    public function getPropertyList() {
        return $this->propertyList;
    }

    public function setPropertyList(Erfurt_Sparql_Query2_PropertyList $propertyList) {
        if($propertyList->isEmpty()){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_BlankNodePropertyList::setPropertyList must not be an empty PropertyList', E_USER_ERROR);
        }
        $this->propertyList = $propertyList;
    }

    public function __toString(){
        return $this->getSparql();
    }

}
?>

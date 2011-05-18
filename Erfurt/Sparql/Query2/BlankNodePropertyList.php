<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlankNodePropertyList
 *
 * @author jonas
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

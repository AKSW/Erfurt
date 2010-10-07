<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 27, 2010
 * Time: 5:26:52 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_Assertion extends Erfurt_Owl_Structured_Axiom {

    private $individuals = array();

    function __construct($individual) {
        $this->addElement($individual);
    }

    public function addElement($element){
        $this->individuals []= $element;
    }

    public function getElements(){
        return $this->individuals;
    }
}
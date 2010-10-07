<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 3, 2010
 * Time: 6:05:21 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    private $dataPropertyExpressions = array();

    function __construct($dataPropertyExpression) {
        $this->addElement($dataPropertyExpression);
    }

    public function addElement($element){
        $this->dataPropertyExpressions []= $element;
    }
}
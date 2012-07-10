<?php

class Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    private $dataPropertyExpressions = array();

    function __construct($dataPropertyExpression) {
        $this->addElement($dataPropertyExpression);
    }

    public function addElement($element) {
        $this->dataPropertyExpressions [] = $element;
    }
}
<?php

class Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom extends Erfurt_Owl_Structured_Axiom {

    private $objectPropertyExpressions = array();

    function __construct($objectPropertyExpression) {
        $this->addElement($objectPropertyExpression);
    }

    public function addElement($objectPropertyExpression) {
        // TODO merge arrays
        $this->objectPropertyExpressions [] = $objectPropertyExpression;
    }

}

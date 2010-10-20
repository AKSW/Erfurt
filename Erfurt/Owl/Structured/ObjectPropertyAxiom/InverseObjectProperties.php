<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_InverseObjectProperties extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    function __construct($objectPropertyExpression1, $objectPropertyExpression2) {
        parent::__construct($objectPropertyExpression1);
        $this->addElement($objectPropertyExpression2);
    }

}

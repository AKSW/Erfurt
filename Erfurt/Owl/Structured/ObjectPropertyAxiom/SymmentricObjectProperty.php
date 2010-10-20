<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_SymmetricObjectProperty extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $asymmetric;

    function __construct($objectPropertyExpression, $asymmetric) {
        parent::__construct($objectPropertyExpression);
        $this->asymmetric = $asymmetric;
    }
}

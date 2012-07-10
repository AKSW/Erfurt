<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_FunctionalObjectProperty extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $inverse;

    function __construct($objectPropertyExpression, $inverse = false) {
        parent::__construct($objectPropertyExpression);
        $this->inverse = $inverse;
    }
}

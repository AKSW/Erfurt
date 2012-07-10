<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_ObjectPropertyRange extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $range;

    function __construct($objectPropertyExpression, $range) {
        parent::__construct($objectPropertyExpression);
        $this->range = $range;
    }

}

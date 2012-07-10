<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_ReflexiveObjectProperty extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $irreflexive;

    function __construct($objectPropertyExpression, $irreflexive) {
        parent::__construct($objectPropertyExpression);
        $this->irreflexive = $irreflexive;
    }

}

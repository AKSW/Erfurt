<?php

class Erfurt_Owl_Structured_Axiom_Assertion_ObjectPropertyAssertion extends Erfurt_Owl_Structured_Axiom_Assertion {

    private $negative;
    private $objectPropertyExpression;

    function __construct($objectPropertyExpression, $sourceIndividual, $targetIndividual, $negative = false) {
        parent::__construct($sourceIndividual);
        $this->addElement($targetIndividual);
        $this->objectPropertyExpression = $objectPropertyExpression;
        $this->negative = $negative;
    }
}

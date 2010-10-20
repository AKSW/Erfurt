<?php

class Erfurt_Owl_Structured_Axiom_Assertion_DataPropertyAssertion extends Erfurt_Owl_Structured_Axiom_Assertion {

    private $negative;
    private $dataPropertyExpression;
    private $targetValue;

    function __construct($dataPropertyExpression, $sourceIndividual, $targetValue, $negative = false) {
        parent::__construct($sourceIndividual);
        $this->dataPropertyExpression = $dataPropertyExpression;
        $this->targetValue = $targetValue;
        $this->negative = $negative;
    }

}

<?php

class Erfurt_Owl_Structured_DataPropertyAxiom_DataPropertyRange extends Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    private $range;

    function __construct($range, $dataPropertyExpression) {
        parent::__construct($dataPropertyExpression);
        $this->range = $range;
    }

}
    
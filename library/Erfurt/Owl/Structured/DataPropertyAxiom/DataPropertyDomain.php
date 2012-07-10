<?php

class Erfurt_Owl_Structured_DataPropertyAxiom_DataPropertyDomain extends Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    private $domain;

    function __construct($domain, $dataPropertyExpression) {
        parent::__construct($dataPropertyExpression);
        $this->domain = $domain;
    }
}

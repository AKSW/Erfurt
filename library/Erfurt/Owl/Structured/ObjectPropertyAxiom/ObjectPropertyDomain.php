<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_ObjectPropertyDomain extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $domain;

    function __construct($objectPropertyExpression, $domain) {
        parent::__construct($objectPropertyExpression);
        $this->domain = $domain;
    }

}

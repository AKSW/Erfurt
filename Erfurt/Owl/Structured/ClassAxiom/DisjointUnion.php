<?php

class Erfurt_Owl_Structured_ClassAxiom_DisjointUnion extends Erfurt_Owl_Structured_Axiom_ClassAxiom {

    private $owlClass;

    function __construct($owlClass, $disjointClassExpression) {
        $this->owlClass = $owlClass;
        parent::__construct($disjointClassExpression);
    }
}

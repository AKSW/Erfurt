<?php

class Erfurt_Owl_Structured_ClassExpression_ObjectUnionOf extends Erfurt_Owl_Structured_ClassExpression {

    public function __toString() {
        return implode(" or ", $this->getElements());
    }

    function getPredicateString() {
        return "owl:unionOf";
    }

    public function isComplex() {
        return parent::isComplex();
    }
}

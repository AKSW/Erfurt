<?php

class Erfurt_Owl_Structured_ClassExpression_ObjectIntersectionOf extends Erfurt_Owl_Structured_ClassExpression {

    public function __toString() {
        return implode(" and ", $this->getElements());
    }

    function getPredicateString() {
        return "owl:intersectionOf";
    }

    public function isComplex() {
        return parent::isComplex();
    }
}

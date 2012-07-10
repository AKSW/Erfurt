<?php

class Erfurt_Owl_Structured_ClassExpression_ObjectOneOf extends Erfurt_Owl_Structured_ClassExpression {

    private $individuals;

    function __construct(Erfurt_Owl_Structured_OwlList $list) {
        $this->individuals = $list;
    }

    function getPredicateString() {
        return "owl:oneOf";
    }
}

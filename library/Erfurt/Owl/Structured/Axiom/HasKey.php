<?php

class Erfurt_Owl_Structured_Axiom_HasKey extends Erfurt_Owl_Structured_Axiom {

    private $objectPropertyExpressions;
    private $dataPropertyExpressions;
    private $classExpression;

    function __construct($classExpression, $objectPropertyExpressions, $dataPropertyExpressions) {
        $this->classExpression = $classExpression;
        $this->objectPropertyExpressions = $objectPropertyExpressions;
        $this->dataPropertyExpressions = $dataPropertyExpressions;
    }
}

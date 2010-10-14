<?php
 
class Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf extends Erfurt_Owl_Structured_ClassExpression {

    function __construct($element) {
        parent::__construct($element);
    }

    public function __toString() {
        return "not " . parent::__toString() . "";
    }

    function getPredicateString(){
        return "owl:complementOf";
    }
    
    public function isComplex(){
      return true;
    }
}

<?php

class Erfurt_Owl_Structured_OwlClass extends Erfurt_Owl_Structured_ClassExpression {

    public function __toString() {
        return parent::__toString();
    }

    function __construct(Erfurt_Owl_Structured_Iri $element) {
        parent::__construct($element);
    }

    public function getPredicateString() {
        return "rdf:type";
    }


    public function isComplex(){
        return false;
    }

    public function toArray(){
        $e= $this->getElements();
        return array($e[0]->__toString());
    }
}

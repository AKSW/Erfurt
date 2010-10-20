<?php

class Erfurt_Owl_Structured_OwlClass extends Erfurt_Owl_Structured_ClassExpression {

    public function __toString() {
        return parent::__toString();
    }

    public function toRdfArray() {
        //        parent::createArray($this->getNewBlankNodeId(),"rdf:type", "uri", "owl:class");
        //        parent::toRdfArray();
    }

    function __construct(Erfurt_Owl_Structured_Iri $element) {
        parent::__construct($element);
    }

    public function getPredicateString() {
        return "rdf:type";
    }


}

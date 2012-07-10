<?php

class Erfurt_Owl_Structured_Axiom_AnnotationAxiom extends Erfurt_Owl_Structured_Axiom {

    private $annotationProperty = array();

    function __construct($annotationProperty) {
        $this->addElement($annotationProperty);
    }

    public function addElement($element) {
        $this->annotationProperty [] = $element;
    }

}

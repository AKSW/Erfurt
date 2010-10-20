<?php

class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_AnnotationPropertyRange extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {

    private $range;

    function __construct($annotationProperty, $range) {
        parent::__construct($annotationProperty);
        $this->range = $range;
    }

}

<?php

class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_AnnotationAssertion extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {

    private $annotationSubject;
    private $annotationValue;

    function __construct($annotationProperty, $annotationSubject, $annotationValue) {
        parent::__construct($annotationProperty);
        $this->annotationSubject = $annotationSubject;
        $this->annotationValue = $annotationValue;
    }
}

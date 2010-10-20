<?php

class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_SubAnnotationPropertyOf extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {
    private $subAnnotationProperty;
    private $superAnnotationProperty;

    function __construct($subAnnotationProperty, $superAnnotationProperty) {
        parent::__construct($subAnnotationProperty);
        $this->addElement($superAnnotationProperty);
    }

}

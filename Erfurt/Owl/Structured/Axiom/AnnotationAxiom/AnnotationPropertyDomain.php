<?php

class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_AnnotationPropertyDomain extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {
    private $domain;

    function __construct($annotationProperty, $domain) {
        parent::__construct($annotationProperty);
        $this->domain = $domain;
    }

}

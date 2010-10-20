<?php

class Erfurt_Owl_Structured_Annotations_Annotation {
    private $annotationAnnotations;
    private $annotationProperty;
    private $annotationValue;

    function __construct($annotationAnnotations, $annotationProperty, $annotationValue) {
        $this->annotationAnnotations = $annotationAnnotations;
        $this->annotationProperty = $annotationProperty;
        $this->annotationValue = $annotationValue;
    }

}

<?php

class Erfurt_Owl_Structured_Iri extends Erfurt_Owl_Structured_Annotations_AnnotationValue {
    private $iri;

    public function __construct($iri) {
        $this->iri = $iri;
    }

    public function getValue() {
        return $this->iri;
    }

    public function __toString() {
        return $this->getValue();
    }

    public function getElements() {
        return $this->getValue();
    }

    public function isComplex() {
        return false;
    }
}

<?php

class Erfurt_Owl_Structured_Individual implements Erfurt_Owl_Structured_IRdfPhp {

    private $value;

    function __construct($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    function __toString() {
        return "" . $this->value;
    }

    public function toRdfArray() {
        return $this->value;
    }

    public function isComplex() {
        return false;
    }
}

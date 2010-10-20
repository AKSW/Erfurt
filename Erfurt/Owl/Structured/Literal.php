<?php

class Erfurt_Owl_Structured_Literal extends Erfurt_Owl_Structured_Annotations_AnnotationValue {

    private $lexicalValue;

    function __construct($value) {
        $this->lexicalValue = $value;
    }

    public function __toString() {
        return $this->lexicalValue;
    }

    public function getLexicalValue() {
        return "\"" . $this->lexicalValue;
    }

    public function getValue() {
        return $this->getLexicalValue();
    }
}

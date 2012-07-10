<?php

class Erfurt_Owl_Structured_Literal extends Erfurt_Owl_Structured_Annotations_AnnotationValue {


  // TODO implement toAray() method and call it from Util::addFirst? to correctly process literals with lang tag

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
        return $this->lexicalValue;
    }

    public function isComplex() {
        return false; 
    }

    public function getDatatypeString(){
      return (method_exists($this, "getDatatype"))? "xsd:". $this->getDatatype() : null;
    }
}

<?php

class Erfurt_Owl_Structured_ClassAxiom_SubClassOf extends Erfurt_Owl_Structured_Axiom_ClassAxiom {

    private $mainClass;

    function __construct($element, $classExpression = null)
    {
        parent::__construct($classExpression);
        $this->mainClass = $element;
    }

    public function __toString() {
        return $this->getValue();
    }

    public function getValue() {
        $elements = $this->getElements();
        $retval = "Class: " . $this->mainClass->__toString();
        foreach ($elements as $e) {
          $retval .= " SubClassOf: " . $e;
        }
        return $retval;
    }

    public function toTriples() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    public function isComplex()
    {
        return false;
    }

    public function getPredicateString() {
        return "rdfs:subClassOf";
    }

    public function toArray() {
        $retval = array();
        $e = $this->getElements();
        $ee = array();
        foreach ($e as $element) {
          $ee = array_merge($ee, $element->toArray());
        }
        foreach ($ee as $element) {
          if (is_array($element)) {
            $triple = array(
              $this->mainClass->getValue(),
              $this->getPredicateString(),
              $element[0]
            );
            if (!in_array($triple, $retval)) {
              $retval []= $triple;
            }
            $retval []= $element;
          } else {
            $retval []= array(
              $this->mainClass->getValue(),
              $this->getPredicateString(),
              $element
            );
          }
        }
        return $retval;
    }
}

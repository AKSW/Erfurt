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
        $ee = $e[0]->toArray();
        $retval [] = array(
                         $this->mainClass->getValue(),
                         $this->getPredicateString(),
                         is_array($ee[0]) ? $ee[0][0] : $ee[0]
                     );
        return is_array($ee[0]) ? array_merge($retval, $ee) : $retval;
    }
}

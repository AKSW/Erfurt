<?php

class Erfurt_Owl_Structured_Axiom_ClassAxiom extends Erfurt_Owl_Structured_Axiom implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $classExpressions = array();

    function __construct($element = null, $nextElement = null) {
        if ($element) $this->addElement($element);
        if ($nextElement) $this->addElement($nextElement);
    }

    public function addElement($element) {
        $this->classExpressions [] = $element;
    }

    public function getElements() {
        return $this->classExpressions;
    }

    public function getPredicateString() {
        // TODO: Implement getPredicateString() method.
    }

    public function toN3() {
        //        return Erfurt_Owl_Structured_Util_N3Converter::makeTriple()
        // TODO: Implement toN3() method.
    }

    public function __toString() {
        // TODO: Implement __toString() method.
    }

    public function getValue() {
        // TODO: Implement getValue() method.
    }

    public function toRdfArray() {
        // TODO: Implement toRdfArray() method.
    }
}

<?php

class Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf extends Erfurt_Owl_Structured_ClassExpression {

    function __construct($element) {
        parent::__construct($element);
    }

    public function __toString() {
        return "not " . parent::__toString();
    }

    function getPredicateString() {
        return "owl:complementOf";
    }

    public function isComplex() {
        return true;
    }

    public function toArray() {
        if (count($this->getElements()) > 1) {
            return parent::toArray();
        } else {
            $e = $this->getElements();
            $retval = array();
            $e = $this->getElements();
            $retval [] = array(
                Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
                $this->getPredicateString(),
                Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId()
            );
            $retval [] = array(
                Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
                "owl:Class",
                $e[0]->__toString()
            );
            return $retval;
        }
    }
}

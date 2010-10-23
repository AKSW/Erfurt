<?php

class Erfurt_Owl_Structured_ClassExpression
    implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $elements;

    function __construct($element = null) {
        $this->elements = array();
        if (is_array($element)) {
            $this->elements = array_merge($this->elements, $element);
        } else if ($element) $this->addElement($element);
    }

    public function addElement($element) {
        $this->elements [] = $element;
    }

    public function getElements() {
        return $this->elements;
    }

    public function __toString() {
        return implode(" ", $this->getElements());
    }

    public function toRdfArray() {
        //TODO implement
    }

    public function getValue() {
        throw new Exception ("please implement this method in appropriate subclass");
    }

    public function isComplex() {
        return count($this->elements) > 1; // || ($this->getElements() && $this->elements[0]->isComplex());
    }

    public function getPredicateString() {
        throw new Exception ("please implement this method in appropriate subclass");
    }

    public function toTriples() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    public function toArray() {
        $retval = array();
        $bnodeId = null;
        if ($this->isComplex())
            $list = Erfurt_Owl_Structured_Util_N3Converter::makeList($this->getElements());
        $retval [] = array(
            $bnodeId ? $bnodeId : $bnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId(),
            "rdf:type",
            "owl:Class"
        );
        if ($this->isComplex()) {
            $retval [] = array(
                $bnodeId,
                $this->getPredicateString(),
                $list[0][0]
            );
            return array_merge($retval, $list);
        } else {
            $e = $this->getElements();
            $ee = $e[0]->toArray();
            $retval [] = array(
                $bnodeId,
                $this->getPredicateString(),
                is_array($ee[0]) ? $ee[0][0] : $ee[0]
            );
            return is_array($ee[0]) ? array_merge($retval, $ee) : $retval;
        }
    }
}
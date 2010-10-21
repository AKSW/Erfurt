<?php

class Erfurt_Owl_Structured_ClassExpression implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $elements;
    private $mainNodeBlankId;

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

    //TODO cleanup
    public function toRdfArray() {
        $this->mainNodeBlankId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
        $retval = Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, "rdf:type", "owl:Class");

        if ($this->isComplex()) {
            $newBnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
            $retval [] = Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, $this->getPredicateString(), $newBnodeId);
            foreach ($this->getElements() as $element) {
                $retval [] = $element->toRdfArray();
            }
        }
        else $retval [] = Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, $this->getPredicateString(), $this->getValue());
        return $retval;
    }

    public function getValue() {
        throw new Exception ("please implement this method in appropriate subclass");
    }

    public function isComplex() {
        return count($this->elements) > 1 || ($this->getElements() && $this->elements[0]->isComplex());
    }

    public function getMainNodeBlankId() {
        return $this->mainNodeBlankId;
    }

    public function getPredicateString() {
        throw new Exception ("please implement this method in appropriate subclass");
    }

    public function toTriples() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    public function toArray() {
        if ($this->isComplex()) {
            $retval = array();
            $e = $this->getElements();
            if ($e[0] instanceof Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf) {
                $retval = array_merge($retval, $e[0]->toArray());
            } else {
                $list = Erfurt_Owl_Structured_Util_N3Converter::makeList($this->getElements());
                $retval [] = array(
                    Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
                    $this->getPredicateString(),
                    $list[0][0]
                );
                $retval = array_merge($retval, $list);
            }
            return $retval;
        } else {
            $retval = array();
            $e = $this->getElements();
            $retval [] = array(
                Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
                "owl:Class",
                $e[0]->__toString()
            );
            return $retval;
        }
    }
}


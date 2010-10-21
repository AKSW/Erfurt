<?php

class Erfurt_Owl_Structured_DataRange implements Erfurt_Owl_Structured_ITriples {

    private $arity;

    public function getArity() {
        return $this->arity;
    }

    public function setArity($newArity) {
        $this->arity = $newArity;
    }


    public function getPredicateString() {
        throw new Exception ("please implement this method in appropriate subclass");
    }

    public function toTriples() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray(($this->toArray()));
    }

    public function toArray() {
        return array(
            Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
            "rdf:type",
            "rdfs:Datatype"
        );
    }

    public function isComplex() {
        return true;
    }
}

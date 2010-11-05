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

    public function toRdfPhp() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeRdfPhpFromArray(($this->toArray()));
    }

    public function toArray() {
        $retval = array();
        $list = null;
        if($this->getElements() && count($this->getElements())>1)
            $list = Erfurt_Owl_Structured_Util_N3Converter::makeList($this->getElements());
        else if($this->getElements() && $this->getElements()->isComplex()){
          $list = $this->getElements()->toArray();
        }
        $retval []= array(
                        Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
                        "rdf:type",
                        "rdfs:Datatype"
                    );
        $retval [] = array(
                         Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
                         $this->getPredicateString(),
                         $list ? $list[0][0] : $this->getElements()
                     );
      if($list) $retval = array_merge($retval, $list);
      return $retval;
    }

    public function isComplex() {
        return true;
    }
}

<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction extends Erfurt_Owl_Structured_ClassExpression implements Erfurt_Owl_Structured_IRestriction, Erfurt_Owl_Structured_ITriples{
    
    private $classExpression;
    private $objectPropertyExpression;

    function __construct($objectPropertyExpression, $classExpression=null) {
        $this->objectPropertyExpression = $objectPropertyExpression;
        $this->classExpression = $classExpression;
    }

    public function __toString() {
            return  $this->objectPropertyExpression . " " . $this->getRestrictionLabel()
                    . ($this->classExpression? " " . $this->classExpression : "");
    }

    protected function getClassExpression(){
        return $this->classExpression;
    }

    protected function getObjectPropertyExpression(){
        return $this->objectPropertyExpression;
    }
    
    public function getRestrictionLabel() {
        throw new Exception("don't call directly!");
    }

    public function getPredicateString() {
        throw new Exception("don't call directly!");
    }

    public function toRdfArray() {
        $bnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
        $retval = Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, "rdf:type", "owl:Restriction");
        $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, "owl:onProperty", $this->getObjectPropertyExpression());
        $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, $this->getPredicateString(), $this->getClassExpression());
        return $retval;
    }

    public function toTriples() {
        $retval = Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(), "rdf:type", "owl:Restriction");
        $retval .= Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(), "owl:onProperty", $this->getObjectPropertyExpression());
        $retval .= Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(), $this->getPredicateString(), $this->getClassExpression());
        return $retval;
    }

    
}

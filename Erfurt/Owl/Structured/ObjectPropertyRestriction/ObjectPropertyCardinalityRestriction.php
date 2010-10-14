<?php
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction extends Erfurt_Owl_Structured_ObjectPropertyRestriction{

    private $cardinality;

    function __construct($objectPropertyExpression, $nni, $primary = null) {
        parent::__construct($objectPropertyExpression, $primary);
        $this->cardinality = $nni;
    }

    public function __toString() {
        return $this->getObjectPropertyExpression()." ".$this->getRestrictionLabel()." "
                . $this->cardinality . ($this->getClassExpression()? " " . $this->getClassExpression() : "");
    }
    public function toRdfArray() {
        $bnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
        $retval = Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, "rdf:type", "owl:Restriction");
        $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, $this->getPredicateString(), new Erfurt_Owl_Structured_Literal_TypedLiteral($this->cardinality, "xsd:nonNegativeInteger"));
        $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, "owl:onProperty", $this->getObjectPropertyExpression());
        $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($bnodeId, "owl:onClass", $this->getClassExpression());
        return $retval;
    }

    public function toTriples() {
      return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    public function toArray(){
      $retval = array();

      $retval []= array(
        Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
        "rdf:type",
        "owl:Restriction");

      $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          $this->getPredicateString(),
          $this->cardinality,
          "xsd:nonNegativeInteger");

      $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          "owl:onProperty",
          $this->getObjectPropertyExpression());
      
      $ce = $this->getClassExpression(); 
      if(is_array($ce)){
        $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          "owl:onClass",
          $ce[0][0]
        );
        $retval = array_merge($retval,$ce);
      }else
        $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          "owl:onClass",
          $ce
          );
      return $retval;
    }
}

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

    public function toArray(){
      $retval = array();
      $ce = $this->getClassExpression();
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
      
      if($ce->isComplex()){
        $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          "owl:onClass",
          $this->getFirtsElement()
        );
        $retval = array_merge($retval,$this->ce_array);
      }else {
        $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
          "owl:onClass",
          $ce->__toString()
          );
	}
      return $retval;
    }

	// hack! needed to init the array and return the first element
	// otherwise problem with bnodes
	private function getFirtsElement()
	{
		$x = $this->getClassExpression()->getElements();
		$this->ce_array = $x[0]->toArray();
		return $this->ce_array[0][0];
	}
}

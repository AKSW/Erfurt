<?php
 
class Erfurt_Owl_Structured_ClassExpression implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $elements;
    private $mainNodeBlankId;

    function __construct($element=null) {
        $this->elements = array();
		if (is_array($element)) {
			$this->elements = array_merge($this->elements, $element);
		} else if($element) $this->addElement($element);
    }

    public function addElement($element){
        $this->elements []= $element;
    }

    public function getElements(){
        return $this->elements;
    }
    public function __toString() {
        return implode(" ", $this->getElements());
    }

    public function toRdfArray() {
        $this->mainNodeBlankId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
        $retval = Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, "rdf:type", "owl:Class");

        if($this->isComplex()){
            $newBnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
            $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, $this->getPredicateString(), $newBnodeId);
            foreach($this->getElements() as $element){
                $retval []= $element->toRdfArray();
            }
        }
        else $retval []= Erfurt_Owl_Structured_Util_RdfArray::createArray($this->mainNodeBlankId, $this->getPredicateString(), $this->getValue());
        return $retval;
    }

    public function getValue() {
        // TODO: Implement getValue() method.
    }

    public function isComplex(){
        return count($this->elements)>1 || ($this->getElements() && $this->elements[0]->isComplex());
    }

    public function getMainNodeBlankId(){
        return $this->mainNodeBlankId;
    }

    public function getPredicateString() {
      throw new Exception ("not yet implemented"); // do i need it at all???
    }

    public function toTriples() {
      return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    protected function toArray(){
      if($this->isComplex()){
        $retval = array();
		$e = $this->getElements();
		if ($e[0] instanceof Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf) {
			$retval = array_merge($retval,$e[0]->toArray());
		} else {
        	$list = $this->makeList($this->getElements());
        	$retval []= array(
            	Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
            	$this->getPredicateString(),
            	$list[0][0]
        		);
        	$retval = array_merge($retval, $list);
		}
        return $retval;
      }else{
        $retval = array();
        $e = $this->getElements();
        $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
          "owl:Class",
          $e[0]->__toString()
        );
        return $retval;
      }
    }

    private function makeList($elements){
      $retval = array();
      Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId();
      foreach($elements as $key => $e){
        if($e->isComplex()){
          $ee = $e->toArray();
          $retval []= array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "rdf:first",
            $ee[0][0]
            );
          $retval=array_merge($retval,$ee);
        } else
          $retval []= array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "rdf:first",
            $e
          );
        $retval []= array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "rdf:rest",
            $key == count($elements)-1 ?
              "rdf:nil": Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId()
        );
      }
      return $retval;
    }
}

<?php
 
class Erfurt_Owl_Structured_ClassExpression implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $elements;
    private $mainNodeBlankId;

    function __construct($element=null) {
        $this->elements = array();
        if($element)$this->addElement($element);
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
	//TODO implement
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
      throw new Exception ("not yet implemented");
    }

    public function toTriples() {
      return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    protected function toArray(){
      $retval = array();
      $list = $this->makeList($this->getElements());
      $retval []= array(
          Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
          $this->getPredicateString(),
          $list[0][0]
      );
      $retval = array_merge($retval, $list);
      return $retval;
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

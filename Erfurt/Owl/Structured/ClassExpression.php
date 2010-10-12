<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 3:56:39 PM
 * To change this template use File | Settings | File Templates.
 */
 
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
        return count($this->elements)>1;
    }

    public function getMainNodeBlankId(){
        return $this->mainNodeBlankId;
    }

    public function getPredicateString() {
        // TODO: Implement getPredicateString() method.
    }

    public function toTriples() {
      $retval = "";
      $list = $this->makeList($this->getElements());

      return Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(), $this->getPredicateString(), $list[0]) . $list[1];
    }

    private function makeList($elements){
      $retval = "";
      $firstId = Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId();
      foreach($elements as $key => $e){
        $retval .= Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(), "rdf:first", $e);
        $retval .= Erfurt_Owl_Structured_Util_N3Converter::makeTriple(Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(), "rdf:rest", $key == count($elements)-1 ? "rdf:nil": Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId());
      }
      return array($firstId, $retval);
    }
}

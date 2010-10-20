<?php

class Erfurt_Owl_Structured_OwlList implements Erfurt_Owl_Structured_IRdfPhp {

    private $list;

    public function toRdfArray() {
        $bNodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
        $nextBNodeId = null;
        $retval = array();
        $elements = $this->getElements();
        foreach ($elements as $element) {
            $retval [] = Erfurt_Owl_Structured_Util_RdfArray::createArray(
                $bNodeId,
                "rdf:first",
                $element->getValue(),
                $element instanceof Erfurt_Owl_Structured_Literal_StringLiteral ? $element->getLang() : null,
                method_exists($element, "getDatatype") ? $element->getDatatype() : null
            );
            $nextBNodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBnodeId();
            $retval [] = Erfurt_Owl_Structured_Util_RdfArray::createArray(
                $bNodeId,
                "rdf:rest",
                ($element != end($elements) ? $nextBNodeId : "rdf:nil")
            );
            $bNodeId = $nextBNodeId;
        }
        return $retval;
    }

    public function __toString() {
        return implode(", ", $this->getElements());
    }

    public function __construct($element) {
        $this->list = array();
        $this->addElement($element);
    }

    public function getElements() {
        return $this->list;
    }

    public function addElement($element) {
        $this->list [] = $element;
    }

    public function addAllElements(Erfurt_Owl_Structured_OwlList $list) {
        foreach ($list->getElements() as $element) {
            $this->list [] = $element;
        }
    }

    public function getValue() {
        // TODO: Implement getValue() method.
    }
}
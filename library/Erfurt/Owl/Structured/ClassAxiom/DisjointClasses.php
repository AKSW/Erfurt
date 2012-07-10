<?php

class Erfurt_Owl_Structured_ClassAxiom_DisjointClasses extends Erfurt_Owl_Structured_Axiom_ClassAxiom {

    function __construct($annotations, $list) {
        parent::__construct();
        foreach ($list->getElements() as $element) {
            $this->addElement($element);
        }
    }

    public function __toString() {
        $elements = $this->getElements();
        return $elements[0] . " owl:equivalentClass " . $elements[1];
    }

    public function toRdfArray() {
        $retval = Erfurt_Owl_Structured_Util_RdfArray::createArray("bnode", "rdf:type", "owl:AllDisjointClasses");
        $retval [] = Erfurt_Owl_Structured_Util_RdfArray::createArray("bnode", "owl:members", implode(" ", $this->getElements()));
        return $retval;
    }
}
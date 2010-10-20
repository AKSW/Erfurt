<?php

class Erfurt_Owl_Structured_ClassAxiom_SubClassOf extends Erfurt_Owl_Structured_Axiom_ClassAxiom {

    public function __toString() {
        $elements = $this->getElements();
        return $elements[0] . " rdfs:subClassOf " . $elements[1];
    }

    public function getValue() {
        // TODO: Implement getValue() method.
    }

    public function toRdfArray() {
        // TODO: Implement toRdfArray() method.
    }
}

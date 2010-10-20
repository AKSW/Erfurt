<?php

class Erfurt_Owl_Structured_ClassAxiom_EquivalentClasses extends Erfurt_Owl_Structured_Axiom_ClassAxiom {

    public function __toString() {
        $elements = $this->getElements();
        return $elements[0] . " owl:equivalentClass " . $elements[1];
    }

}

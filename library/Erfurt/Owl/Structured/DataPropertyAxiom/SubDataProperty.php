<?php

class Erfurt_Owl_Structured_DataPropertyAxiom_SubDataProperty extends Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    function __construct($subDataPropertyOf, $superDataPropertyOf) {
        parent::__construct($subDataPropertyOf);
        $this->addElement($superDataPropertyOf);
    }


}

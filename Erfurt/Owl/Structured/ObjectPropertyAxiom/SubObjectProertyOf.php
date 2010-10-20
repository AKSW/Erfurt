<?php

class Erfurt_Owl_Structured_ObjectPropertyAxiom_SubObjectProertyOf extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    function __construct($subObjectPropertyExpressions, $superObjectPropertyExpressions) {
        parent::__construct($subObjectPropertyExpressions);
        $this->addElement($superObjectPropertyExpressions);
    }
}

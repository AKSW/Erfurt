<?php

class Erfurt_Owl_Structured_Axiom_Assertion extends Erfurt_Owl_Structured_Axiom {

    private $individuals = array();

    function __construct($individual) {
        $this->addElement($individual);
    }

    public function addElement($element) {
        $this->individuals [] = $element;
    }

    public function getElements() {
        return $this->individuals;
    }
}
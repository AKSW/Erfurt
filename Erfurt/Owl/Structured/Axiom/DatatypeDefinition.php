<?php

class Erfurt_Owl_Structured_Axiom_DatatypeDefinition extends Erfurt_Owl_Structured_Axiom {

    private $dataRange;
    private $dataType;

    function __construct($dataType, $dataRange) {
        $this->dataType = $dataType;
        $this->dataRange = $dataRange;
    }
}

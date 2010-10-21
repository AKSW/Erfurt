<?php

class Erfurt_Owl_Structured_DataRange_DataComplementOf extends Erfurt_Owl_Structured_DataRange {

    private $dataRange;

    public function __construct($dataAtomic) {
        $this->dataRange = $dataAtomic;
    }

    function __toString() {
        return "not " . $this->dataRange;
    }
}

<?php

class Erfurt_Owl_Structured_DataRange_DataIntersectionOf extends Erfurt_Owl_Structured_DataRange {

    // array
    private $dataRanges;

    function __toString() {
        return implode(" and ", $this->dataRanges);
    }

    function __construct($dataPrimary) {
        $this->dataRanges = $dataPrimary;
    }

    public function getPredicateString() {
        return "owl:intersectionOf";
    }

    public function getElements(){
      return $this->dataRanges;
    }
}

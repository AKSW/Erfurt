<?php

class Erfurt_Owl_Structured_DataRange_DataIntersectionOf extends Erfurt_Owl_Structured_DataRange {

    private $dataRanges;

    function __toString() {
        return implode(" and ", $this->dataRanges);
    }

    function __construct($dataPrimary) {
        $this->dataRanges = $dataPrimary;
    }
}

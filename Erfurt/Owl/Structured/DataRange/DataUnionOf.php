<?php

class Erfurt_Owl_Structured_DataRange_DataUnionOf extends Erfurt_Owl_Structured_DataRange {

    private $dataRanges;

    public function __construct($dataRange) {
        $this->dataRanges = $dataRange;
    }

    public function __toString() {
        return implode(" or ", $this->dataRanges);
    }
}

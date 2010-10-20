<?php

class Erfurt_Owl_Structured_DataRange_DataOneOf extends Erfurt_Owl_Structured_DataRange {

    private $literals;

    function __construct(Erfurt_Owl_Structured_OwlList_LiteralList $list) {
        $this->literals = $list;
    }

    function __toString() {
        return "{" . $this->literals . "}";
    }

}

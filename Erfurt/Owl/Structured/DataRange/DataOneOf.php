<?php

class Erfurt_Owl_Structured_DataRange_DataOneOf extends Erfurt_Owl_Structured_DataRange {

    private $literals;

    function __construct(Erfurt_Owl_Structured_OwlList_LiteralList $list) {
        $this->literals = $list;
    }

    function __toString() {
        return "{" . $this->literals . "}";
    }

    public function getPredicateString() {
        return "owl:oneOf";
    }

    public function toArray() {
        $retval = array();
        $list = Erfurt_Owl_Structured_Util_N3Converter::makeList($this->literals->getElements());
        $retval [] = parent::toArray();
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            $this->getPredicateString(),
            $list[0][0]
        );
        return array_merge($retval,$list);
    }
}

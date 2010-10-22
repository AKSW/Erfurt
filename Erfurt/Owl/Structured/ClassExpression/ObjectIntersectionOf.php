<?php

class Erfurt_Owl_Structured_ClassExpression_ObjectIntersectionOf
    extends Erfurt_Owl_Structured_ClassExpression {

    public function __toString() {
        return implode(" and ", $this->getElements());
    }

    function getPredicateString() {
        return "owl:intersectionOf";
    }

    public function isComplex() {
        return parent::isComplex();
    }

//    public function toArray() {
//        $list = Erfurt_Owl_Structured_Util_N3Converter::makeList($this->getElements());
//        $retval = parent::toArray();
//        $retval [] = array(
//            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
//            $this->getPredicateString(),
//            $list[0][0]
//        );
//        return array_merge($retval, $list);
//    }
}

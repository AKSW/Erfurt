<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataAllValuesFrom
    extends Erfurt_Owl_Structured_DataPropertyRestriction {

    public function getRestrictionLabel() {
        return "only";
    }

    public function getPredicateString() {
        return "owl:allValuesFrom";
    }

    public function toArray() {
        $datarangeList = $this->getDataRange()->toArray();
        $retval = parent::toArray();
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            $this->getPredicateString(),
            $datarangeList[0][0]
        );
        return array_merge($retval, $datarangeList);
    }
}

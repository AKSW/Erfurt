<?php

class Erfurt_Owl_Structured_DataPropertyRestriction extends Erfurt_Owl_Structured_ClassExpression implements Erfurt_Owl_Structured_IRestriction {

    private $dataPropertyExpression;
    private $dataRange;

    public function __toString() {
        return $this->dataPropertyExpression . " " . $this->getRestrictionLabel()
                . ($this->dataRange ? " " . $this->dataRange : "");
    }

    function __construct($dataPropertyExpression, $dataRange = null) {
        parent::__construct();
        $this->setDataPropertyExpression($dataPropertyExpression);
        if (isset($dataRange)) $this->dataRange = $dataRange;
    }

    protected function getDataPropertyExpression() {
        return $this->dataPropertyExpression;
    }

    public function setDataPropertyExpression($property) {
        $this->dataPropertyExpression = $property;
    }

    protected function setDataRange($dataRange) {
        $this->dataRange = $dataRange;
    }

    protected function getDataRange() {
        return $this->dataRange;
    }


    public function getRestrictionLabel() {
        throw new Exception("don't call directly!");
    }

    protected function toArray() {
        $retval = array();
        $datarangeList = $this->dataRange->toArray();
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
            "rdf:type",
            "owl:Restriction"
        );
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "owl:onProperty",
            $this->getDataPropertyExpression()
        );
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            $this->getPredicateString(),
            $datarangeList[0][0]
        );
        $retval = array_merge($retval, $datarangeList);
        return $retval;
    }
}

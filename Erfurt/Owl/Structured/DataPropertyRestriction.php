<?php
// http://www.w3.org/2007/OWL/refcardA4
class Erfurt_Owl_Structured_DataPropertyRestriction
    extends Erfurt_Owl_Structured_ClassExpression
    implements Erfurt_Owl_Structured_IRestriction {

    private $dataPropertyExpression;
    private $dataRange;

    //TODO add n-ary data range and multiple data properties
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

    protected function getDataRange() {
        return $this->dataRange;
    }

    public function getRestrictionLabel() {
        throw new Exception("don't call directly!");
    }

    public function toArray() {
        $retval = array();
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
        return $retval;
    }
}

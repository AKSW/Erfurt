<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataPropertyCardinalityRestriction extends Erfurt_Owl_Structured_DataPropertyRestriction {

    private $cardinality;

    function __construct($dataPropertyExpression, $nni, $dataRange = null) {
        parent::__construct($dataPropertyExpression, $dataRange);
        $this->cardinality = $nni;
    }

    public function getCardinality() {
        return $this->cardinality;
    }

    public function __toString() {
        return $this->getDataPropertyExpression() . " " . $this->getRestrictionLabel()
                . ($this->getCardinality() ? " " . $this->getCardinality() : "")
                . ($this->getDataRange() ? " (" . $this->getDataRange() . ")" : "");
    }

}

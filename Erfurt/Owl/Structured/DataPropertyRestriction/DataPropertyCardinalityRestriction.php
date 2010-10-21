<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataPropertyCardinalityRestriction
    extends Erfurt_Owl_Structured_DataPropertyRestriction {

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
                . " " . $this->getCardinality()
                . ($this->getDataRange() ? " (" . $this->getDataRange() . ")" : "");
    }

    public function toArray() {
        $retval = array();
        if ($this->getDataRange()) {
            $drList = $this->getDataRange()->toArray();
        }
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
            $this->getPredicateString(isset($drList)),
            $this->cardinality,
            "xsd:nonNegativeInteger"
        );
        if ($this->getDataRange()) {
            $retval [] = array(
                Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
                "owl:onDataRange",
                $drList[0][0]
            );
            $retval = array_merge($retval, $drList);
        }
        return $retval;
    }
}

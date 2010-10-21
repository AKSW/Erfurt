<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataHasValue
    extends Erfurt_Owl_Structured_DataPropertyRestriction {

    private $literal;

    function __construct($dataPropertyExpression, $literal) {
        parent::__construct($dataPropertyExpression);
        $this->literal = $literal;
    }

    public function getRestrictionLabel() {
        return "value";
    }

    public function getPredicateString() {
        return "owl:hasValue";
    }

    public function __toString() {
        return $this->getDataPropertyExpression() . " " . $this->getRestrictionLabel()
                . " " . $this->literal;
    }

    public function toArray() {
        $retval = parent::toArray();
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            $this->getPredicateString(),
            $this->literal->__toString()
        );
        return $retval;
    }
}

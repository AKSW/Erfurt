<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataHasValue extends Erfurt_Owl_Structured_DataPropertyRestriction {

    private $literal;

    function __construct($dataPropertyExpression, $literal) {
        parent::__construct($dataPropertyExpression);
        $this->literal = $literal;
    }

    public function getRestrictionLabel() {
        return "value";
    }

    public function __toString() {
        return implode(", ", $this->getDataPropertyExpression()) . " " . $this->getRestrictionLabel()
                . " " . $this->literal;
    }

}

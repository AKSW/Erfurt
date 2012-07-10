<?php

class Erfurt_Owl_Structured_ObjectPropertyExpression extends Erfurt_Owl_Structured_ClassExpression {

    private $objectPropertyExpression;
    private $inverse;

    function __construct($objectPropertyExpression, $inverse = false) {
        parent::__construct();
        $this->objectPropertyExpression = $objectPropertyExpression;
        $this->inverse = $inverse;
    }

    protected function getObjectPropertyExpression() {
        return $this->objectPropertyExpression;
    }

    public function __toString() {
        return ($this->inverse ? "inverse " : "") . $this->objectPropertyExpression;
    }
}

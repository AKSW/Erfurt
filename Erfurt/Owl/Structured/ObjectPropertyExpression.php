<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 9:11:06 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyExpression extends Erfurt_Owl_Structured_ClassExpression{

    private $objectPropertyExpression;
    private $inverse;

    function __construct($objectPropertyExpression, $inverse = false) {
        parent::__construct();
        $this->objectPropertyExpression = $objectPropertyExpression;
        $this->inverse = $inverse;
    }

    protected function getObjectPropertyExpression(){
        return $this->objectPropertyExpression;
    }

    public function __toString() {
        return ($this->inverse?"inverse ":"") . $this->objectPropertyExpression;
    }
}
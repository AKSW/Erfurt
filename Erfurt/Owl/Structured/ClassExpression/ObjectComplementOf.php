<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 3:57:28 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf extends Erfurt_Owl_Structured_ClassExpression {

    function __construct($element) {
        parent::__construct($element);
    }

    public function __toString() {
        return "not " . parent::__toString() . "";
    }

    function getPredicateString(){
        return "owl:complementOf";
    }
}

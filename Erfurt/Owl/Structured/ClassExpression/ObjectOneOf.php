<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 3:57:47 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ClassExpression_ObjectOneOf extends Erfurt_Owl_Structured_ClassExpression {

    private $individuals;

    function __construct(Erfurt_Owl_Structured_OwlList $list) {
        $this->individuals = $list;
    }

    function getPredicateString(){
        return "owl:oneOf";
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 5, 2010
 * Time: 11:49:57 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyAxiom_ObjectPropertyRange extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $range;

    function __construct($objectPropertyExpression, $range) {
        parent::__construct($objectPropertyExpression);
        $this->range = $range;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 5, 2010
 * Time: 11:56:47 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyAxiom_FunctionalObjectProperty extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $inverse;

    function __construct($objectPropertyExpression, $inverse = false) {
        parent::__construct($objectPropertyExpression);
        $this->inverse = $inverse;
    }
}

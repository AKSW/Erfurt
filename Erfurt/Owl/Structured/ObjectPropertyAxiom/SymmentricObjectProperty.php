<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 5, 2010
 * Time: 11:58:35 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyAxiom_SymmetricObjectProperty extends Erfurt_Owl_Structured_Axiom_ObjectPropertyAxiom {

    private $asymmetric;

    function __construct($objectPropertyExpression, $asymmetric) {
        parent::__construct($objectPropertyExpression);
        $this->asymmetric = $asymmetric;
    }
}

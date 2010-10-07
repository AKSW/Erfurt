<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 3, 2010
 * Time: 6:07:33 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataPropertyAxiom_DataPropertyRange extends Erfurt_Owl_Structured_Axiom_DataPropertyAxiom {

    private $range;

    function __construct($range, $dataPropertyExpression) {
        parent::__construct($dataPropertyExpression);
        $this->range = $range;
    }

}
    
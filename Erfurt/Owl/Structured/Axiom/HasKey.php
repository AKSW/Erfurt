<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 3, 2010
 * Time: 6:13:19 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_HasKey extends Erfurt_Owl_Structured_Axiom {

    private $objectPropertyExpressions;
    private $dataPropertyExpressions;
    private $classExpression;

    function __construct($classExpression, $objectPropertyExpressions, $dataPropertyExpressions) {
        $this->classExpression = $classExpression;
        $this->objectPropertyExpressions = $objectPropertyExpressions;
        $this->dataPropertyExpressions = $dataPropertyExpressions;
    }
}

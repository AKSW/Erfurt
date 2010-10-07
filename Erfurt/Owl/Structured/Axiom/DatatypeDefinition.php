<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 4:39:32 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_DatatypeDefinition extends Erfurt_Owl_Structured_Axiom{

    private $dataRange;
    private $dataType;

    function __construct($dataType, $dataRange) {
        $this->dataType = $dataType;
        $this->dataRange = $dataRange;
    }
}

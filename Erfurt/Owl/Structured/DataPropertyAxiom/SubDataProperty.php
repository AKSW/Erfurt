<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 3, 2010
 * Time: 6:05:01 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataPropertyAxiom_SubDataProperty extends Erfurt_Owl_Structured_Axiom_DataPropertyAxiom{

    function __construct($subDataPropertyOf, $superDataPropertyOf) {
        parent::__construct($subDataPropertyOf);
        $this->addElement($superDataPropertyOf);
    }


}

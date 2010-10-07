<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 9:12:04 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectSomeValuesFrom extends Erfurt_Owl_Structured_ObjectPropertyRestriction{

    public function getRestrictionLabel() {
        return "some";
    }

    public function getPredicateString(){
        return "owl:someValuesFrom";
    }
}
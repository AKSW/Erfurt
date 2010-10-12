<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 9:43:28 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMinCardinality extends Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction {

    public function getRestrictionLabel(){
        return "min";
    }

    public function getPredicateString() {
      return "owl:minQualifiedCardinality";
    }

}

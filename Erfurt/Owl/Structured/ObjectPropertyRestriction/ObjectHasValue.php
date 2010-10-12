<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 9:15:53 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasValue extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "value";
    }

    public function getPredicateString() {
      return "owl:hasValue";
    }
}

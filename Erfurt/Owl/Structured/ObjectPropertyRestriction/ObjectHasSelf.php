<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 9:15:19 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasSelf extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "Self";
    }
    
    public function getPredicateString(){
        return "owl:hasSelf";
    }

    protected function getClassExpression() {
        return new Erfurt_Owl_Structured_Literal_TypedLiteral("true", "xsd:boolean");
    }

}

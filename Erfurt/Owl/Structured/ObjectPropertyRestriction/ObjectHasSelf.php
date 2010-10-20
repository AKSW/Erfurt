<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasSelf extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "Self";
    }

    public function getPredicateString() {
        return "owl:hasSelf";
    }

    protected function getClassExpression() {
        return new Erfurt_Owl_Structured_Literal_TypedLiteral("true", "xsd:boolean");
    }

}

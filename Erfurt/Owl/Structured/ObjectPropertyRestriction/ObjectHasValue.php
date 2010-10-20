<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasValue extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "value";
    }

    public function getPredicateString() {
        return "owl:hasValue";
    }
}

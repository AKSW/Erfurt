<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectSomeValuesFrom extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "some";
    }

    public function getPredicateString() {
        return "owl:someValuesFrom";
    }
}
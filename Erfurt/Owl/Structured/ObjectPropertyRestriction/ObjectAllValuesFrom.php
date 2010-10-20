<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectAllValuesFrom extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    public function getRestrictionLabel() {
        return "only";
    }

    public function getPredicateString() {
        return "owl:allValuesFrom";
    }

}

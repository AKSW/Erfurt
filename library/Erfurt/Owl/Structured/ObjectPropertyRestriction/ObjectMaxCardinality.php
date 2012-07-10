<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMaxCardinality extends Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction {

    public function getRestrictionLabel() {
        return "max";
    }

    public function getPredicateString($qualified = false) {
        return $qualified ? "owl:maxQualifiedCardinality" : "owl:maxCardinality";
    }
}

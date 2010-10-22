<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMinCardinality
    extends Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction {

    public function getRestrictionLabel() {
        return "min";
    }

    public function getPredicateString($qualified = false) {
        return $qualified ? "owl:minQualifiedCardinality" : "owl:minCardinality";
    }

}

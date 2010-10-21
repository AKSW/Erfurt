<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataMaxCardinality
    extends Erfurt_Owl_Structured_DataPropertyRestriction_DataPropertyCardinalityRestriction {

    public function getRestrictionLabel() {
        return "max";
    }

    public function getPredicateString($qualified = false) {
        return $qualified ? "owl:maxQualifiedCardinality" : "owl:maxCardinality";
    }
}

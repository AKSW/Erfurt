<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataExactCardinality
    extends Erfurt_Owl_Structured_DataPropertyRestriction_DataPropertyCardinalityRestriction {

    public function getRestrictionLabel() {
        return "exactly";
    }

    public function getPredicateString($qualified = false) {
        return $qualified ? "owl:qualifiedCardinality" : "owl:cardinality";
    }
}

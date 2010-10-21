<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataMinCardinality
    extends Erfurt_Owl_Structured_DataPropertyRestriction_DataPropertyCardinalityRestriction {

    public function getRestrictionLabel() {
        return "min";
    }

    public function getPredicateString($qualified = false) {
        return $qualified ? "owl:minQualifiedCardinality" : "owl:minCardinality";
    }
}

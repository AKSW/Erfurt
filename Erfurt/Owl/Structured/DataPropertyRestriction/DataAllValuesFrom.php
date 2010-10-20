<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataAllValuesFrom extends Erfurt_Owl_Structured_DataPropertyRestriction implements Erfurt_Owl_Structured_ITriples {

    public function getRestrictionLabel() {
        return "only";
    }

    public function getPredicateString() {
      return "owl:someValuesFrom";
    }
}

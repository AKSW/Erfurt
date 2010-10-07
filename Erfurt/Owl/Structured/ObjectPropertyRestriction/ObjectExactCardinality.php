<?php
 
class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectExactCardinality extends Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction{

    public function getRestrictionLabel() {
        return "exactly";
   }
    public function getPredicateString() {
      return "owl:qualifiedCardinality";
    }
}

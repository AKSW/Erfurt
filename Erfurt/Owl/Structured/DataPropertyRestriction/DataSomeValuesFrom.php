<?php

class Erfurt_Owl_Structured_DataPropertyRestriction_DataSomeValuesFrom extends Erfurt_Owl_Structured_DataPropertyRestriction implements Erfurt_Owl_Structured_ITriples {

    public function getRestrictionLabel() {
        return "some";
    }

    public function getPredicateString() {
       return "owl:someValuesFrom";
    }

}

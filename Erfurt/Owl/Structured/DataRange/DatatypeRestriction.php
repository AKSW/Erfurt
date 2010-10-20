<?php

class Erfurt_Owl_Structured_DataRange_DatatypeRestriction extends Erfurt_Owl_Structured_DataRange implements Erfurt_Owl_Structured_ITriples {

    private $dataType;
    private $restriction = array();

    function __construct($dataType) {
        parent::__construct();
        $this->setDataType($dataType);
    }

    public function setDataType($dataType) {
        $this->dataType = $dataType;
    }

    public function addRestriction($facet, $restrictionValue) {
        $this->restriction [] = array($facet, $restrictionValue);
    }

    function __toString() {
        $rstring = "";
        foreach ($this->restriction as $rv) {
            $rstring .= implode(" ", $rv) . ", ";
        }
        $rstring = rtrim($rstring, ", ");
        return $this->dataType . " [" . $rstring . "]";
    }

    public function getPredicateString() {
        return "owl:Restrictions";
    }

    public function toTriples() {
        $retval = "_:b owl:onDatatype xsd:" . $this->dataType . "; owl:withRestrictions (";
        $rstring = "";
        foreach ($this->restriction as $rv) {
            $rstring .= "[" . implode(" ", $rv) . "]";
        }
        $rstring .= ")";
        $retval .= $rstring;
        return $retval;
    }
}

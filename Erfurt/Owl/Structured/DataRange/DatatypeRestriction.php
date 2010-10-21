<?php

class Erfurt_Owl_Structured_DataRange_DatatypeRestriction extends Erfurt_Owl_Structured_DataRange implements Erfurt_Owl_Structured_ITriples {

    private $dataType;
    private $restriction = array();

    private $mapping = array(
        '>' => "xsd:maxExclusive",
        '<' => "xsd:minExclusive",
        '>=' => "xsd:maxInclusive",
        '<=' => "xsd:minInclusive"
    );

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
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriplesFromArray($this->toArray());
    }

    public function toArray() {
        $retval = array();
        $list = $this->restrictionsToArray();
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
            "rdf:type",
            "rdfs:Datatype"
        );
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "owl:onDatatype",
            "xsd:" . $this->dataType
        );
        $retval [] = array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "owl:withRestrictions",
            $list[0][0]
        );
        $retval = array_merge($retval, $list);
        return $retval;
    }

    private function restrictionsToArray() {
        $retval = array();
        if (count($this->restriction) > 1) {
            Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId();
            foreach ($this->restriction as $key => $restr) {
                $retval [] = array(
                    $oldBNodeId = Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
                    "rdf:first",
                    Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId()
                );
                $retval [] = $this->mapRestriction($restr);
                $retval [] = array(
                    $oldBNodeId,
                    "rdf:rest",
                    $key == count($this->restriction) - 1 ?
                            "rdf:nil" : Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId()
                );
            }
        } else {
            $retval [] = $this->mapRestriction($this->restriction[0]);
        }
        return $retval;
    }

    private function mapRestriction($r) {
        return array(
            Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            $this->mapping[$r[0]],
            $r[1]->getValue(),
            $r[1]->getDatatypeString()
        );
    }

}

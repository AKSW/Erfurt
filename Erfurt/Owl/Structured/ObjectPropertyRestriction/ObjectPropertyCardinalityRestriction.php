<?php

class Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectPropertyCardinalityRestriction
    extends Erfurt_Owl_Structured_ObjectPropertyRestriction {

    private $cardinality;
    private $ce_array;

    function __construct($objectPropertyExpression, $nni, $primary = null) {
        parent::__construct($objectPropertyExpression, $primary);
        $this->cardinality = $nni;
    }

    public function __toString() {
        return $this->getObjectPropertyExpression() . " " . $this->getRestrictionLabel() . " "
                . $this->cardinality . ($this->getClassExpression() ? " " . $this->getClassExpression() : "");
    }

    public function toRdfArray() {
    }

    public function toArray() {
        $retval = array();
        $bnodeId = null;
        $ce = $this->getClassExpression();
        $retval [] = array(
            $bnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId(),
            "rdf:type",
            "owl:Restriction");

        $retval [] = array(
            $bnodeId,
            "owl:onProperty",
            $this->getObjectPropertyExpression()
        );

        $retval [] = array(
            $bnodeId,
            $this->getPredicateString(isset($ce)),
            $this->cardinality,
            "xsd:nonNegativeInteger"
        );

        if (!$ce) return $retval;


        if ($ce->isComplex()) {
            $retval [] = array(
                $bnodeId,
                "owl:onClass",
                $this->getFirstElement()
            );
            $retval = array_merge($retval, $this->ce_array);
        } else {
            $ee = $ce->toArray();
            $retval [] = array(
                $bnodeId,
                "owl:onClass",
                is_array($ee[0]) ? $ee[0][0] : $ee[0]
            );
            return is_array($ee[0]) ? array_merge($retval, $ee) : $retval;
        }
        return $retval;
    }

    // hack! needed to init the array and return the first element
    // otherwise problem with bnodes
    private function getFirstElement() {
        $x = $this->getClassExpression()->getElements();
        $this->ce_array = $x[0]->toArray();
        return $this->ce_array[0][0];
    }
}

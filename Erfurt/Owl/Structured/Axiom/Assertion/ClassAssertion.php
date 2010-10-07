<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 27, 2010
 * Time: 5:25:47 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_Assertion_ClassAssertion extends Erfurt_Owl_Structured_Axiom_Assertion implements Erfurt_Owl_Structured_IRdfPhp, Erfurt_Owl_Structured_ITriples {

    private $classExpression;

    function __construct($individual, $classExpression) {
        parent::__construct($individual);
        $this->classExpression = $classExpression;
    }

    function __toString() {
        return  implode(" ", $this->getElements()). $this->getPredicateString(). $this->classExpression ;
    }

    public function getValue() {
        // TODO: Implement getValue() method.
    }

    public function toRdfArray() {
        return Erfurt_Owl_Structured_Util_RdfArray::createArray(implode(" ", $this->getElements()), "rdf:type", "".$this->classExpression);
    }

    public function getPredicateString() {
        return "rdf:type";
    }

    public function toN3() {
        return Erfurt_Owl_Structured_Util_N3Converter::makeTriple(
            implode(" ", $this->getElements()),
            $this->getPredicateString(),
            $this->classExpression
        );
    }
}
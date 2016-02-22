<?php

/**
 * helper class for second-order relations
 * @package    Erfurt_Sparql_Query2
 */
abstract class Erfurt_Sparql_Query2_RelHelper extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_Expression
{
    protected $conjuction;
    protected $element1;
    protected $element2;

    /**
     * create a relation
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct();
        $this->element1 = $e1;
        $this->element2 = $e2;
    }

    /**
     * set the first element
     * @param Erfurt_Sparql_Query2_Expression $element
     * @return Erfurt_Sparql_Query2_RelHelper
     */
    public function setElement1(Erfurt_Sparql_Query2_Expression $element) {
        $this->element1 = $element;
        return $this; //for chaining
    }

    /**
     * set the second element
     * @param Erfurt_Sparql_Query2_Expression $element
     * @return Erfurt_Sparql_Query2_RelHelper
     */
    public function setElement2(Erfurt_Sparql_Query2_Expression $element) {
        $this->element2 = $element;
        return $this; //for chaining
    }

    /**
     * get string representation
     * @return string
     */
    public function getSparql() {
        return $this->element1->getSparql().' '.$this->conjuction.' '.$this->element2->getSparql();
    }
}

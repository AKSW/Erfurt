<?php

/**
 * represents a built-in bound function call
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_bound extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Var $element
     */
    public function __construct(Erfurt_Sparql_Query2_Var $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'BOUND('.$this->element->getSparql().')';
    }
}

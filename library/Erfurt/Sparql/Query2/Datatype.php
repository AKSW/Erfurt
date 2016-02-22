<?php

/**
 * represents a built-in datatype function call
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_Datatype extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'DATATYPE('.$this->element->getSparql().')';
    }
}

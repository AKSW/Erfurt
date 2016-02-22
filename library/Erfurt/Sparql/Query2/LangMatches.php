<?php

/**
 * represents a built-in LangMatches function call
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_LangMatches extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element1
     * @param Erfurt_Sparql_Query2_Expression $element2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2) {
        $this->element1 = $element1;
        $this->element2 = $element2;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'LANGMATCHES('.$this->element1->getSparql().', '.$this->element2->getSparql().')';
    }
}

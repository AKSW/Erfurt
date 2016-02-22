<?php

/**
 * represents a built-in "regex" function call
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_Regex extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;
    protected $element3;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element1
     * @param Erfurt_Sparql_Query2_Expression $element2
     * @param <type> $element3
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2, $element3 = null) {
        $this->element1 = $element1;
        $this->element2 = $element2;

        if ($element3 != null) {
            if ($element3 instanceof Erfurt_Sparql_Query2_Expression) {
                $this->element3 = $element3;
            } else {
                throw new RuntimeException('Argument 3 passed to Erfurt_Sparql_Query2_Regex::__construct must be an instance of Erfurt_Sparql_Query2_Expression or null, instance of '.typeHelper($element3).' given');
            }
        }
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'REGEX('.$this->element1->getSparql().
', '.$this->element2->getSparql().
(gettype($this->element3)=='object'?(', '.$this->element3->getSparql()):'').')';
    }
}

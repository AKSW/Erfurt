<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_InExpression implements Erfurt_Sparql_Query2_Expression
{
    protected $_term = null;
    protected $_elements = array();

    public function __construct(Erfurt_Sparql_Query2_Expression $term, $elements = array())
    {
        $this->_term = $term;
        $this->_elements = $elements;
    }

    public function getSparql()
    {
        $inParts = array();
        foreach ($this->_elements as $elem) {
            $inParts[] = $elem->getSparql();
        }
        return $this->_term->getSparql() . ' IN (' . implode(',', $inParts) . ')';
    }
}

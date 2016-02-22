<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
abstract class Erfurt_Sparql_Query2_UnaryExpressionHelper extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IF_UnaryExpression
{
    protected $mod;
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_PrimaryExpression $element
     */
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return $this->mod.$this->element->getSparql();
    }
}

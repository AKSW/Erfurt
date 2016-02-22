<?php

/**
 * wrapps an expression in brackets
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_BrackettedExpression extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $expression;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $expression
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $expression) {
        $this->expression = $expression;
        parent::__construct();
    }

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $expression
     * @return Erfurt_Sparql_Query2_BrackettedExpression
     */
    public function setExpression(Erfurt_Sparql_Query2_Expression $expression) {
        $this->expression = $expression;
        return $this; //for chaining
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return '('.$this->expression->getSparql().')';
    }
}

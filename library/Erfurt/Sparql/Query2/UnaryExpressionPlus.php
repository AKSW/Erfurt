<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_UnaryExpressionPlus extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '+';

    /**
     *
     * @param Erfurt_Sparql_Query2_PrimaryExpression $element
     */
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        parent::__construct($element);
    }
}

<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_UnaryExpressionNot extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '!';

    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        parent::__construct($element);
    }
}

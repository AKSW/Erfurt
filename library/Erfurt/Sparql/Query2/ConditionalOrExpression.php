<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_ConditionalOrExpression extends Erfurt_Sparql_Query2_AndOrHelper
{
    protected $conjunction = '||';

    public function __construct($elements = array()) {
        parent::__construct($elements);
    }
}

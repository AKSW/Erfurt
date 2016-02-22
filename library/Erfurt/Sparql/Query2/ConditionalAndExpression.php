<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_ConditionalAndExpression extends Erfurt_Sparql_Query2_AndOrHelper implements Erfurt_Sparql_Query2_IF_ConditionalAndExpression
{
    protected $conjunction = '&&';

    /**
     *
     * @param <type> $elements
     */
    public function __construct($elements = array()) {
        parent::__construct($elements);
    }
}

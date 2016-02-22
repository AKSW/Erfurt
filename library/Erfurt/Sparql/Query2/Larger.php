<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_Larger extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '>';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}

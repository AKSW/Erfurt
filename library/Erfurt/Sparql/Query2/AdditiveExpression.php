<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_AdditiveExpression extends Erfurt_Sparql_Query2_AddMultHelper implements Erfurt_Sparql_Query2_IF_AdditiveExpression
{
    const operator = '+';
    const invOperator = '-';

    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * @param <type> $op + or -. operator used to connect to the remaining elements
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return Erfurt_Sparql_Query2_AdditiveExpression $this
     */
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp) {
        if ($op == self::operator || $op == self::invOperator ) {
            //a hack to convert a expression that is added first when added with a minus as operator - would be omitted otherwise. maybe not usefull?!
            if ($op == self::invOperator && count($this->elements)==0) {
                if ($exp instanceof Erfurt_Sparql_Query2_RDFLiteral) {
                    $exp->setValue( invOperator . $exp->getValue() );
                } else if ($exp instanceof Erfurt_Sparql_Query2_NumericLiteral) {
                    $exp->setValue((-1)*$exp->getValue());
                } else {
                    $exp = new Erfurt_Sparql_Query2_UnaryExpressionMinus($exp);
                }
            }
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
            $exp->addParent($this);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::minus or Erfurt_Sparql_Query2_AdditiveExpression::plus');
        }
        return $this; //for chaining
    }
}

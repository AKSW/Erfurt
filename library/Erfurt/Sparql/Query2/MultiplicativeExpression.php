<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_MultiplicativeExpression
    extends Erfurt_Sparql_Query2_AddMultHelper
    implements Erfurt_Sparql_Query2_IF_MultiplicativeExpression
{
    const operator = '*';
    const invOperator = '/';

    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * @param string $op * or / operator used to connect to the remaining elements
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return Erfurt_Sparql_Query2_MultiplicativeExpression $this
     */
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp) {
        if ($op == self::operator || $op == self::invOperator ) {
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::times or Erfurt_Sparql_Query2_AdditiveExpression::divided');
        }
        $exp->addParent($this);
        return $this; //for chaining
    }

        /**
     * get string representation
     * @return string
     */
    public function getSparql() {
        $sparql = '';

        $countElements = count($this->elements);

        for ($i=0; $i<$countElements; ++$i) {
            if ($i == 0) {
                if($this->elements[$i]['op'] == self::invOperator){
                    $sparql .= ' 1'.$this->elements[$i]['op'].' '; // => 1/x
                }
            } else {
                $sparql .= ' '.$this->elements[$i]['op'].' ';
            }
            $sparql .= $this->elements[$i]['exp']->getSparql();
        }
        if ($countElements > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }
}

<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
abstract class Erfurt_Sparql_Query2_AddMultHelper extends Erfurt_Sparql_Query2_ContainerHelper{

    const operator = null;
    const invOperator = null;
    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }

    abstract public function addElement($op, Erfurt_Sparql_Query2_Expression $element);

    /**
     * get string representation
     * @return string
     */
    public function getSparql() {
        $sparql = '';

        $countElements = count($this->elements);

        for ($i=0; $i<$countElements; ++$i) {
            if ($i != 0 || $this->elements[$i]['op'] == self::invOperator) {
                $sparql .= ' '.$this->elements[$i]['op'].' ';
            }
            $sparql .= $this->elements[$i]['exp']->getSparql();
        }
        if (count($this->elements) > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }

    /**
     *
     * @param array $elements array of Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AddMultHelper $this
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }

        foreach ($elements as $element) {
            if (!($element['exp'] instanceof Erfurt_Sparql_Query2_Expression) || !isset($element['op'])) {
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of arrays consisting of a field "exp" with type Erfurt_Sparql_Query2_Expression and a field "op" containing the operator (+,-,*,/) as string');
                return $this; //for chaining
            } else {
                $this->addElement($element['op'], $element['exp']);
            }
        }

        return $this; //for chaining
    }
}

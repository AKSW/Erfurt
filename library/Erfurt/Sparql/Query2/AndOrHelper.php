<?php

/**
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_AndOrHelper
    extends Erfurt_Sparql_Query2_ContainerHelper
    implements Erfurt_Sparql_Query2_IF_ConditionalOrExpression
{
    protected $conjunction;

    /**
     *
     * @param array $elements array of Erfurt_Sparql_Query2_Expression
     */
    public function __construct($elements = array()) {
        parent::__construct();
        if (!empty($elements)) {
            $this->setElements($elements);
        }
    }

    /**
     * @param Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AndOrHelper
     */
    public function addElement($element) {
        if (is_string($element)) {
            $element = new Erfurt_Sparql_Query2_RDFLiteral($element);
        }
        if (!($element instanceof Erfurt_Sparql_Query2_Expression)) {
             throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be an instance of Erfurt_Sparql_Query2_Expression or string, instance of '.typeHelper($element).' given');
             exit;
        }
        $element->addParent($this);
        $this->elements[] = $element;
        return $this; //for chaining
    }

    /**
     * get the string-representation of this expression
     * @return string
     */
    public function getSparql() {
        $sparql = '';

        $countElements = count($this->elements);

        for ($i=0; $i<$countElements; ++$i) {
            $sparql .= $this->elements[$i]->getSparql();
            if (isset($this->elements[$i+1])) {
                $sparql .= ' '.$this->conjunction.' ';
            }
        }
        if (count($this->elements) > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }

    /**
     * set an array of alements at once
     * @param array $elements of Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AndOrHelper
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }

        foreach ($elements as $element) {
            if (!($element instanceof Erfurt_Sparql_Query2_Expression)) {
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of Erfurt_Sparql_Query2_Expression');
                return $this; //for chaining
            }
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}

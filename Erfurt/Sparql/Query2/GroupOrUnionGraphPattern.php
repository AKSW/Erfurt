<?php
/**
 * Erfurt Sparql Query2 - GroupOrUnionGraphPattern.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_GroupOrUnionGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern
{    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "{[Triples...]} UNION {[Triples...]}"
     * @return string
     */
     public function getSparql() {
        $sparql = '';
        
        $countElements = count($this->elements);

        for ($i = 0; $i < $countElements; ++$i) {
            if($this->elements[$i] instanceof Erfurt_Sparql_Query2_OptionalGraphPattern){
               $sparql .= ' { ';
            }
            $sparql .= $this->elements[$i]->getSparql();
            if($this->elements[$i] instanceof Erfurt_Sparql_Query2_OptionalGraphPattern){
               $sparql .= ' } ';
            }
            if ($i < (count($this->elements)-1)) {
                $sparql .= ' UNION ';
            }
        }
        
        return $sparql;
    }
    
    /**
     * addElement
     * @param Erfurt_Sparql_Query2_GroupGraphPattern $element
     * @return Erfurt_Sparql_Query2_GroupOrUnionGraphPattern $this
     */
    public function addElement($element) {
        if (!($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern))
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::addElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern, instance of '.typeHelper($element).' given');
        $this->elements[] = $element;
        $element->addParent($this);
        return $this; //for chaining
    }
    
    /**
     * setElement
     * @param int $i
     * @param Erfurt_Sparql_Query2_GroupGraphPattern $element
     * @return Erfurt_Sparql_Query2_GroupOrUnionGraphPattern $this
     */
    public function setElement($i, $element) {
        if (!($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern))
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::setElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern, instance of '.typeHelper($element).' given');
        $this->elements[$i] = $element;
        $element->addParent($this);
        return $this; //for chaining
    }
    
    /**
     * setElements
     * overwrite all elements at once with a array of new ones
     * @param array $elements array of Erfurt_Sparql_Query2_GroupGraphPattern
     * @return Erfurt_Sparql_Query2_GroupGraphPattern $this
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array');
        }
        
        foreach ($elements as $element) {
            if (!($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern)) {
                throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::setElements : must be an array of instances of Erfurt_Sparql_Query2_GroupGraphPattern');
                return $this; //for chaining
            } else {
                $element->addParent($this);
            }
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}
?>

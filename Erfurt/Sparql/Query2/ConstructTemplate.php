<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt Sparql Query2 - ConstructTemplate
 * 
 * is like a GroupGraphPattern but you can only add triples
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_ConstructTemplate extends Erfurt_Sparql_Query2_GroupGraphPattern
{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * addElement
     * @param Erfurt_Sparql_Query2_IF_TriplesSameSubject $element
     * @return Erfurt_Sparql_Query2_ConstructTemplate $this
     */
    public function addElement($element) {
        if (!($element instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject))
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_ConstructTemplate::addElement must be an instance of Erfurt_Sparql_Query2_IF_TriplesSameSubject, instance of '.typeHelper($element).' given');
        $this->elements[] = $element;
        $element->addParent($this);
        return $this; //for chaining
    }
    
    /**
     * setElement
     * @param int $i
     * @param Erfurt_Sparql_Query2_IF_TriplesSameSubject $element
     * @return Erfurt_Sparql_Query2_ConstructTemplate $this
     */
    public function setElement($i, $element) {
        if (!is_int($i)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::setElement must be an instance of integer, instance of '.typeHelper($i).' given');
        }
        if (!($element instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject) ) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::addElement must be an instance of Erfurt_Sparql_Query2_IF_TriplesSameSubject');
        }
        $this->elements[$i] = $element;
        $element->addParent($this);
        return $this; //for chaining
    }
    
    /**
     * setElements
     * @param array $elements array of Erfurt_Sparql_Query2_IF_TriplesSameSubject 
     * @return Erfurt_Sparql_Query2_ConstructTemplate $this
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array');
        }
        
        foreach ($elements as $element) {
            if (!($element instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject)) {
                throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_GroupOrUnionGraphPattern::setElements : must be an array of instances of Erfurt_Sparql_Query2_IF_TriplesSameSubject');
                return $this; //for chaining
            } else $element->addParent($this);
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}
?>

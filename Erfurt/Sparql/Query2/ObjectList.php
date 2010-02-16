<?php
/**
 * Erfurt Sparql Query2 - ObjectList
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: ObjectList.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */

class Erfurt_Sparql_Query2_ObjectList extends Erfurt_Sparql_Query2_ContainerHelper implements Erfurt_Sparql_Query2_IF_ObjectList
{
    /**
     * @param array array of Erfurt_Sparql_Query2_GraphNode
     */
    public function __construct ($objects) {
        $this->setElements($objects);
        parent::__construct();
    }
    
    /**
     * addElement
     * @param Erfurt_Sparql_Query2_GraphNode $element
     * @return Erfurt_Sparql_Query2_Collection $this
     */
    public function addElement(Erfurt_Sparql_Query2_GraphNode $element) {
        $this->elements[] = $element;
        return $this;
    }
    
    /**
     * setElement
     * @param int $i
     * @param Erfurt_Sparql_Query2_GraphNode $element
     * @return Erfurt_Sparql_Query2_Collection $this
     */
    public function setElement($i, Erfurt_Sparql_Query2_GraphNode $element) {
        $this->elements[$i] = $element;
        return $this;
    }
    
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_ObjectList::setElements must be an array of Erfurt_Sparql_Query2_GraphNode\'s, instance of '.typeHelper($elements).' given');
        } else {
            foreach ($elements as $object) {
                if (!($object instanceof Erfurt_Sparql_Query2_GraphNode)) {
                    throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_ObjectList::setElements must be an array of Erfurt_Sparql_Query2_GraphNode\'s, instance of '.typeHelper($object).' given');
                } else {
                    $this->addElement($object);
                }
            }
        }
    }

    public function getVars() {
        $ret = array();
        foreach ($this->elements as $element) {
            if ($element instanceof Erfurt_Sparql_Query2_Var)
                $ret[] = $element;
        }
        return $ret;
    }

    //merge?
    public function getNumVars() {
        $ret = 0;
        foreach ($this->elements as $element) {
            if ($element instanceof Erfurt_Sparql_Query2_Var)
                $ret++;
        }
        return $ret;
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "obj1, obj2, obj3"
     * @return string
     */
    public function getSparql() {
        return implode(', ', $this->elements);
    }
    
    public function __toString() {    
        return $this->getSparql();
    }
}
?>

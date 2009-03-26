<?php
/**
 * Represents a constraint. A value constraint is a boolean- valued expression
 * of variables and RDF Terms.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id$
 */
class Erfurt_Sparql_Constraint 
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The expression string.
     * 
     * @var string
     */
    protected $expression;

    /**
     * True if it is an outer filter, false if not.
     * 
     * @var boolean
     */
    protected $outer;

    /**
     * The expression tree
     *
     * @var array
     */
    protected $tree = null;
    
    /**
     * Contains all variables that are used in the constraint expression (recursivly).
     * This array is calculated once, if the tree is set in order to avoid multiple calculation.^
     *
     * @var array
     */
    protected $_usedVars = null;

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Adds an expression string.
     *
     * @param  String $exp the expression String
     * @return void
     */
    public function addExpression($exp)
    {
        $this->expression = $exp;
    }

    /**
     * Returns the expression string.
     *
     * @return String  the expression String
     */
    public function getExpression()
    {
        return $this->expression;
    }
    
    public function getTree()
    {
        return $this->tree;
    }

    public function getUsedVars()
    {
        if (null === $this->_usedVars) {
            $this->_usedVars = array_unique($this->_resolveUsedVarsRecursive($this->tree));
        }
        
        return $this->_usedVars;
    }
    
    /**
     * Returns true if this constraint is an outer filter- false if not.
     *
     * @return boolean
     */
    public function isOuterFilter()
    {
        return $this->outer;
    }

    /**
     * Sets the filter type to outer or inner filter.
     * True for outer false for inner.
     *
     * @param  boolean $boolean
     * @return void
     */
    public function setOuterFilter($boolean)
    {
        $this->outer = $boolean;
    }

    public function setTree($tree)
    {
        $this->tree = $tree;
        
        // If the tree is set or reset, the used variables need to be resolved again.
        $this->_usedVars = null;
    }
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------    
    
    protected function _resolveUsedVarsRecursive($tree) 
    {
        $usedVars = array();
            
        if ($tree['type'] === 'function') {
            foreach ($tree['parameter'] as $paramArray) {
                if ($paramArray['type'] === 'value') {
                    if (is_string($paramArray['value']) && 
                            ($paramArray['value'][0] === '?' || $paramArray['value'][0] === '$')) {
                        
                        $usedVars[] = $paramArray['value'];
                    }
                } else if ($paramArray['type'] === 'function') {
                    foreach ($paramArray['parameter'] as $p) {
                        if (is_string($p['value']) &&
                                ($p['value'][0] === '?' || $p['value'][0] === '$')) {
                            
                            $usedVars[] = $p['value'];
                        }
                    }
                } 
            }
        } else if ($tree['type'] === 'value') {
            if ($tree['value'][0] === '?' || $tree['value'][0] === '$') {
                $usedVars[] = $tree['value'];
            }
        } else {
            $usedVars = array_merge($usedVars, $this->_resolveUsedVarsRecursive($tree['operand1']));
            $usedVars = array_merge($usedVars, $this->_resolveUsedVarsRecursive($tree['operand2']));
        }
        
        return $usedVars;
    }
}

<?php
/**
 * This class models a SPARQL query that can be used within an application in order to make
 * it easier e.g. to set different parts of a query independently.
 *
 * @package erfurt
 * @subpackage    sparql
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: SimpleQuery.php 4019 2009-08-13 15:28:50Z pfrischmuth $
 */
class Erfurt_Sparql_SimpleQuery 
{    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /** @var string */
    protected $_prologuePart = null;
    
    /** @var array */
    protected $_from = array();
    
    /** @var array */
    protected $_fromNamed = array();
    
    /** @var string */
    protected $_wherePart = null;
    
    /** @var string */
    protected $_orderClause = null;
    
    /** @var int */
    protected $_limit = null;
    
    /** @var int */
    protected $_offset = null;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    public function __toString() 
    {
        $queryString = $this->_prologuePart . PHP_EOL;
        
        foreach (array_unique($this->_from) as $from) {
            $queryString .= 'FROM <' . $from . '>' . PHP_EOL;
        }
        
        foreach (array_unique($this->_fromNamed) as $fromNamed) {
            $queryString .= 'FROM NAMED <' . $fromNamed . '>' . PHP_EOL;
        }
        
        $queryString .= $this->_wherePart . ' ';
        
        if ($this->_orderClause !== null) {
            $queryString .= 'ORDER BY ' . $this->_orderClause . PHP_EOL;
        }
        
        if ($this->_limit !== null) {
            $queryString .= 'LIMIT ' . $this->_limit . PHP_EOL;
        }
        
        if ($this->_offset !== null) {
            $queryString .= 'OFFSET ' . $this->_offset . PHP_EOL;
        }
        
        return $queryString;
    }
    
    // ------------------------------------------------------------------------
    // --- Static methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Objective-C style constructor
     *
     * @param string $queryString
     */
    public static function initWithString($queryString)
    {
        $parts = array(
            'prologue'   => array(), 
            'from'       => array(), 
            'from_named' => array(), 
            'where'      => array(), 
            'order'      => array(), 
            'limit'      => array(), 
            'offset'     => array()
        );

        $tokens = array(
            'prologue'   => '/(BASE.*\s)?(PREFIX.*\s)*(\s*ASK|\s*COUNT|(\s*SELECT\s+(DISTINCT\s+)?)(\?\w+\s+|\*)+)/si',  
            'from'       => '/FROM\s+<(.+?)>/i', 
            'from_named' => '/FROM\s+NAMED\s+<(.+?)>/i', 
            'where'      => '/(WHERE\s+)?\{.*\}/si', 
            'order'      => '/ORDER\s+BY\s+(.+\))+/i', 
            'limit'      => '/LIMIT\s+(\d+)/i', 
            'offset'     => '/OFFSET\s+(\d+)/i'
        );

        foreach ($tokens as $key => $pattern) {
            preg_match_all($pattern, $queryString, $parts[$key]);
        }
        
        $queryObject = new self();
        if (isset($parts['prologue'][0][0])) {
            $queryObject->setProloguePart($parts['prologue'][0][0]);   // whole match
        }

        if (isset($parts['from'][1][0])) {
            $queryObject->setFrom($parts['from'][1]);
        }

        if (isset($parts['from_named'][1][0])) {
            $queryObject->setFromNamed($parts['from_named'][1]);
        }

        if (isset($parts['where'][0][0])) {
            $queryObject->setWherePart($parts['where'][0][0]);
        }

        if (isset($parts['order'][1][0])) {
            $queryObject->setOrderClause($parts['order'][1][0]);
        }

        if (isset($parts['limit'][1][0])) {
            $queryObject->setLimit($parts['limit'][1][0]);
        }

        if (isset($parts['offset'][1][0])) {
            $queryObject->setOffset($parts['offset'][1][0]);
        }

        return $queryObject;
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    public function addFrom($iri) 
    {
        $this->_from[] = $iri;
        
        return $this;
    }
    
    public function addFromNamed($iri)
    {
        $this->_fromNamed[] = $iri;
        
        return $this;
    }
    
    public function getFrom()
    {
        return $this->_from;
    }
    
    public function getFromNamed()
    {
        return $this->_fromNamed;
    }
    
    public function getLimit()
    {
        return $this->_limit;
    }
    
    public function getOffset()
    {
        return $this->_offset;
    }
    
    public function getProloguePart()
    {
        return $this->_prologuePart;
    }
    
    public function resetInstance()
    {
        $this->_prologuePart = null;
        $this->_from         = array();
        $this->_fromNamed    = array();
        $this->_wherePart    = null;
        $this->_orderClause  = null;
        $this->_limit        = null;
        $this->_offset       = null;
        
        return $this;
    }
    
    public function setFrom(array $newFromArray)
    {
        $this->_from = $newFromArray;
        
        return $this;
    }
    
    public function setFromNamed(array $newFromNamedArray)
    {
        $this->_fromNamed = $newFromNamedArray;
        
        return $this;
    }
    
    public function setLimit($limit)
    {
        $this->_limit = $limit;
        
        return $this;
    }
    
    public function setOffset($offset)
    {
       $this->_offset = $offset;
       return $this;
    }
        
    public function setOrderClause($orderString) 
    {
        $this->_orderClause = $orderString;
        
        return $this;
    }
    
    public function setProloguePart($prologueString) 
    {
        $this->_prologuePart = $prologueString;
        
        return $this;
    }
     
    public function setWherePart($whereString)
    {
        if (stripos($whereString, 'where') !== false) {
            $this->_wherePart = $whereString;
        } else {
            $this->_wherePart = 'WHERE' . $whereString;
        }
        
        return $this;
    }
}

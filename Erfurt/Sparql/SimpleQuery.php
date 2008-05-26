<?php
class Erfurt_Sparql_SimpleQuery {
    
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
        
    public function setProloguePart($prologueString) 
    {
        $this->_prologuePart = $prologueString;
        
        return $this;
    }
    
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
    
    public function setFrom($newFromArray)
    {
        $this->_from = $newFromArray;
        
        return $this;
    }
    
    public function setFromNamed($newFromNamedArray)
    {
        $this->_fromNamed = $newFromNamedArray;
        
        return $this;
    }
    
    public function setWherePart($whereString)
    {
        $this->_wherePart = $whereString;
        
        return $this;
    }
    
    public function setOrderClause($orderString) 
    {
        $this->_orderClause = $orderString;
        
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
    
    public function __toString() 
    {
        $queryString = $this->_prologuePart . PHP_EOL;
        
        foreach ($this->_from as $from) {
            $queryString .= 'FROM <' . $from . '>' . PHP_EOL;
        }
        
        foreach ($this->_fromNamed as $fromNamed) {
            $queryString .= 'FROM NAMED <' . $fromNamed . '>' . PHP_EOL;
        }
        
        $queryString .= $this->_wherePart;
        
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
}
?>

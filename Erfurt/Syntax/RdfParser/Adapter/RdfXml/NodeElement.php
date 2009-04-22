<?php
class Erfurt_Syntax_RdfParser_Adapter_RdfXml_NodeElement
{
    protected $_resource = null;
    protected $_isVolatile = false;
    protected $_liCounter = 1;
    
    public function __construct($resource)
    {
        $this->_resource = $resource;
    }
    
    public function getResource()
    {
        return $this->_resource;
    }
    
    public function setIsVolatile($isVolatile)
    {
        $this->_isVolatile = $isVolatile;
    }
    
    public function isVolatile()
    {
        return $this->_isVolatile;
    }
    
    public function getNextLiCounter()
    {
        return $this->_liCounter++;
    }
}

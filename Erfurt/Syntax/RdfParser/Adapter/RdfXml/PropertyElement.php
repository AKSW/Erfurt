<?php
class Erfurt_Syntax_RdfParser_Adapter_RdfXml_PropertyElement
{
    protected $_uri = null;
    protected $_reificationUri = null;
    protected $_datatype = null;
    protected $_parseAsCollection = false;
    protected $_lastListResource = null;
    
    public function __construct($uri)
    {
        $this->_uri = $uri;
    }
    
    public function getUri()
    {
        return $this->_uri;
    }
    
    public function isReified()
    {
        if (null !== $this->_reificationUri) {
            return true;
        } else {
            return false;
        }
    }
    
    public function setReificationUri($reifUri)
    {
        $this->_reificationUri = $reifUri;
    }
    
    public function getReificationUri()
    {
        return $this->_reificationUri;
    }
    
    public function setDatatype($datatype)
    {
        $this->_datatype = $datatype;
    }
    
    public function getDatatype()
    {
        return $this->_datatype;
    }
    
    public function parseAsCollection()
    {
        return $this->_parseAsCollection;
    }
    
    public function setParseAsCollection($parseAsCollection)
    {
        $this->_parseAsCollection = $parseAsCollection;
    }
    
    public function getLastListResource()
    {
        return $this->_lastListResource;
    }
    
    public function setLastListResource($lastListResource)
    {
        $this->_lastListResource = $lastListResource;
    }
}

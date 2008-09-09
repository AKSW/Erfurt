<?php

class Erfurt_Rdf_Model {

    protected $_modelIri    = false;
    protected $_baseIri     = false; 
    protected $_isEditable  = false;
    
    public function __construct($modelIri, $baseIri) 
    {   
        $this->_modelIri = $modelIri;
        $this->_baseIri  = $baseIri;
    }
    
    public function __toString()
    {
        return $this->_modelIri;
    }
    
    public function getModelIri() 
    {    
        return $this->_modelIri;
    }
    
    public function getUri()
    {
        return $this->_modelIri;
    }
    
    public function getBaseIri()
    {
        return $this->_baseIri;
    }
    
    public function setEditable($editableFlag)
    {
        $this->_isEditable = $editableFlag;
    }
    
    public function sparqlQueryWithPlainResult($query)
    {    
        return $this->getStore()->executeSparql($this, $query);
    }
    
    public function getStore()
    {    
        require_once 'Erfurt/App.php';
        return Erfurt_App::getInstance()->getStore();
    }
    
    public function addStatement($subject, $predicate, $object, $options)
    {   
        $this->getStore()->addStatement($this->getUri(), $subject, $predicate, $object, $options);
    }
}

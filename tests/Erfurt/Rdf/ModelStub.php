<?php
class Erfurt_Rdf_ModelStub
{   
    public $store = null; 
    public $graphUri = null;
    public $statements = array();
    
    public function __construct($graphUri)
    {
        $this->graphUri = $graphUri;
    }
    
    public function addStatement($subject, $predicate, array $object)
    {
        if (!isset($this->statements[$subject])) {
            $this->statements[$subject] = array();
        }
        
        if (!isset($this->statements[$subject][$predicate])) {
            $this->statements[$subject][$predicate] = array();
        }
        
        $this->statements[$subject][$predicate][] = $object;
    }
    
    public function getModelUri()
    {
        return $this->graphUri;
    }
    
    public function getStore()
    {
        if (null === $this->store) {
            require_once 'Erfurt/StoreStub.php';
            $this->store = new Erfurt_StoreStub();
        }
        
        return $this->store;
    }
}

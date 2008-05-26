<?php
class Erfurt_Rdf_Model {

    protected $_modelIri    = false;
    protected $_baseIri     = false; 
    protected $_isEditable  = false;
    
    public function __construct($modelIri, $baseIri) 
    {   
        $this->_modelIri    = $modelIri;
        $this->_baseIri     = $baseIri;
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
    
    public function setEditable($e) {
        
        $this->_isEditable = $e;
    }
    
    public function sparqlQueryWithPlainResult($query) {
        
        return $this->getStore()->executeSparql($this, $query);
    }
    
    public function getStore() {
        
        require_once 'Erfurt/App.php';
        return Erfurt_App::getInstance()->getStore();
    }
    
    public function addStatement($subject, $predicate, $object, $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type'  => Erfurt_Store::TYPE_IRI))
    {
        $this->getStore()->addStatement($this->getUri(), $subject, $predicate, $object, $options);
    }
}
?>

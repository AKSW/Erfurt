<?php

require_once 'Erfurt/Rdfs/Model.php';

/**
 * Erfurt Owl Model class
 */
class Erfurt_Owl_Model extends Erfurt_Rdfs_Model
{
    /**
     * Imported graph IRIs
     * @var array
     */
    protected $_imports = null;
    
    /**
     * Constructor
     *
     * @param string $modelIri
     * @param string $baseIri
     * @param array $imports
     */
    public function __construct($modelIri, $baseIri = null, array $imports = array())
    {
        parent::__construct($modelIri, $baseIri);
        
        $this->_imports = $imports;
    }
    
    /**
     * Returns an array of graph IRIs this model owl:imports.
     *
     * @return array
     */ 
    public function getImports()
    {
        if (!$this->_imports) {
            $store = $this->getStore();
            $this->_imports = array_values($store->getImportsClosure($this->getModelUri()));
        }
        
        return $this->_imports;
    }
    
    /**
     * Resource factory method
     *
     * @return Erfurt_Owl_Resource
     */
    public function getResource($resourceIri)
    {
        return parent::getResource($resourceIri);
    }
}



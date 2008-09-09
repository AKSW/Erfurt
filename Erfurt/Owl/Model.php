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
    public function __construct($modelIri, $baseIri, array $imports = array())
    {
        parent::__construct($modelIri, $baseIri);
        
        $this->_imports = $imports;
    }
    
    /**
     * Returns an array of graph IRIs this model owl:imports.
     *
     * @return array
     */ 
    public function getImportedIris()
    {
        if (!$this->_imports) {
            $this->_loadImports();
        }
        
        return $this->_imports;
    }
}



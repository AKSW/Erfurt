<?php
require_once 'Erfurt/Store/Adapter/Interface.php';

/**
 * Erfurt RDF Store - Adapter for Redland.
 * 
 * @package erfurt
 * @subpackage    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Redland.php 2899 2009-04-20 13:32:26Z sebastian.dietzold $
 */
class Erfurt_Store_Adapter_Redland implements Erfurt_Store_Adapter_Interface
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_librdf_world      = false;
    private $_librdf_storage    = false;
    private $_librdf_model      = false;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    public function __construct($adapterOptions = array())
    {
        $dbname     = $adapterOptions['dbname'];
        $bdb_dir    = $adapterOptions['bdb_dir'];
        
        if (!is_writable($bdb_dir)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('BDB directory must be writable.');
        }
        
        $this->_librdf_world = librdf_php_get_world();
        
        // try to open existing store or create new if not existing
        $this->_librdf_storage = librdf_new_storage($this->_librdf_world, 
		'hashes', $dbname, 
                "hash-type='bdb',dir='$bdb_dir', contexts='yes'");
		
        $this->_librdf_model = librdf_new_model($this->_librdf_world, $this->_librdf_storage, '');
    }
    
    public function __destruct()
    {   
        librdf_free_storage($this->_librdf_storage);
        librdf_free_model($this->_librdf_model);
        librdf_free_world($this->_librdf_world);
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods (derived from Erfurt_Store_Adapter_Abstract) --------
    // ------------------------------------------------------------------------
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function addStatement($modelIri, $subject, $predicate, $object, $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type' => Erfurt_Store::TYPE_IRI))
    {
        throw new Exception('Not implemented yet.');
    }
    
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_DataInterface */
    public function deleteModel($modelIri) 
    {
        
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = null)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function getAvailableModels($withTitle = false) 
    {    
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function getModel($modelIri) {

        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */ 
    public function getNewModel($modelIri, $baseIri = '', $type = 'rdfs') 
    {    
        throw new Exception('Not implemented yet.');
    }
    
    public function getSupportedExportFormats()
    {
        throw new Exception('Not implemented yet.');
    }
    
    public function getSupportedImportFormats()
    {
        throw new Exception('Not implemented yet.');
    } 
     
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function importRdf($modelIri, $data, $type, $locator)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function isModelAvailable($modelIri) 
    {
        
        librdf_storage_get_contexts();
        
        if (($storage !== null) &&  $this->_checkAc($modelUri, 'view', $useAc)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function sparqlAsk(Erfurt_Sparql_SimpleQuery $query)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Abstract */
    public function sparqlQuery(Erfurt_Sparql_Simple_Query $query, $options=array()) 
    {   
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;
         
        $q = librdf_new_query($this->_librdf_world, 'sparql', null, $query, null);
	
	$result = librdf_model_query_execute($this->_librdf_model, $q);
	$retVal = array();
	
	while ($result && !librdf_query_results_finished($result)) {
	    $row = array();
        $countLibRDFResult = librdf_query_results_get_bindings_count($result);
        
	    for ($i=0; $i < $countLibRDFResult; ++$i) {
	    	$val = librdf_query_results_get_binding_value($result, $i);
		if ($val) {
		    $nval = librdf_node_to_string($val);
		} else {
		    $nval = '';
		}
		
		$b = librdf_query_results_get_binding_name($result, $i);
		
		$row[$b] = $nval;
	    }
	    librdf_query_results_next($result);
	    $retVal[] = $row;
	}
	
	var_dump($retVal);exit;
	
	
    }
}
?>

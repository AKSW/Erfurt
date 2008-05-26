<?php
/**
 * This is the abstract class every Erfurt backend adapter must extend. 
 * 
 * It contains abstract methods that adapters must implement, for the Erfurt Semantic Web Framework works with this
 * methods directly to access the stored data.
 * 
 * @package    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
abstract class Erfurt_Store_Adapter_Abstract
{
    
    
    
    
    /**
     * @param string $modelUri
     * @param Erfurt_Rdf_Resource $s (uri or blank node)
     * @param Erfurt_Rdf_Resource $p (uri, no blank node!)
     * @param Erfurt_Rdf_Node $o (uri, blank node or literal)
     * 
     * @throws Erfurt_Exception Throws an exception if predicate $p is a blank node or if addition of statements
     * fails.
     */
    public abstract function addStatement($modelUri, Erfurt_Rdf_Resource $s, Erfurt_Rdf_Resource $p, 
            Erfurt_Rdf_Node $o);
    
    /**
     * 
     * @param string $modelUri
     * @param mixed $s (Erfurt_Rdf_Resource or boolean false)
     * @param mixed $p (Erfurt_Rdf_Resource (uri, no blank node) or boolean false)
     * @param mixed $o (Erfurt_Rdf_Node or boolean false)
     * 
     * @throws Erfurt_Exception
     */
    public abstract function deleteMatchingStatements($modelUri, $s, $p, $o);
    
    /**
     * @param string $modelUri The uri, which identifies the model.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public abstract function deleteModel($modelUri, $useAc = true);
    
    /**
     * 
     * @param string $modelUri
     * @param string $serializationType One of:
     *                                          - 'xml'
     *                                          - 'n3' or 'nt'
     * @param mixed $filename Either a string containing a absolute filename or boolean false. In case false is given,
     * this method returns a string containing the serialization.
     * 
     * @return string/null
     */
    public abstract function exportRdf($modelUri, $serializationType = 'xml', $filename = false);
    
    /**
     * @param boolean $withTitle Whether to return a human readable title for each available model.
     * @return array Returns an indexed array containing an associative array for each row. Each result row has
     * the following keys:  - 'modelUri'    => Contains the uri of the model.
     *                      - ('title')     => If the $withTitle parameter is given with true as value, this key
     *                                         contains a human readable title for the model resource, else this key
     *                                         will not be set.
     */
    public abstract function getAvailableModels($withTitle = false);
    
    /**
     * @param string $modelUri The uri, which identifies the model.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if model is not available.
     * 
     * @return Erfurt_Rdf_Model Returns an instance of Erfurt_Rdf_Model or one of its subclasses.
     */
    public abstract function getModel($modelUri, $useAc = true);
    
    /**
     * @param string $modelUri
     * @param string $baseUri
     * @param string $type
     * @param boolean $useAc
     * 
     * @throws Erfurt_Exception
     * 
     * @return Erfurt_Rdf_Model
     */
    public abstract function getNewModel($modelUri, $baseUri = '', $type = 'rdfs', $useAc = true);
    
    /**
     * 
     * @param string $modelUri
     * @param string $locator Either a URL or a absolute file name.
     * @param string $type One of: 
     *                              - 'auto' => Tries to detect the type automatically in the following order:
     *                                              
     *                                              1. Detect XML by XML-Header => rdf/xml
     *                                              2. If this fails use the extension of the file
     *                                              3. If this fails throw an exception
     *                              - 'xml'
     *                              - 'n3' or 'nt'
     * 
     * @throws Erfurt_Exception 
     */
    public abstract function importRdf($modelUri, $locator, $type = 'auto');
    
    /**
     * @param string $modelUri The uri, which identifies the model to look for.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @return boolean Returns true if model exists and is available for the user ($useAc === true). 
     */ 
    public abstract function isModelAvailable($modelUri, $useAc = true);
    
    /**
     * @param string $query A string containing a sparql query
     * @param array $modelUris An additional array of modelUris to query against. If a non empty array is given, the 
     * values in this array will overwrite all FROM and FROM NAMED clauses in the query. If the array contains no 
     * element, the FROM and FROM NAMED is evaluated. If non of them is present, all available models are queried.
     * @param string $resultform Currently supported are: 'plain' and 'xml'
     * @param boolean $useAc Whether to check for access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if query is no string.
     * 
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     */
    public abstract function sparqlQuery($query, $modelUris = array(), $resultform = 'plain', $useAc = true);
    
    
}
?>

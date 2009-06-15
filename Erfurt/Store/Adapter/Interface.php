<?php

/**
 * @package erfurt
 * @subpackage    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
interface Erfurt_Store_Adapter_Interface
{
    /**
     * Adds statements in an array to the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array  $statementsArray
     * @param array  $options ("escapeLiteral" => true/false) to disable automatical escaping characters 
     */
    public function addMultipleStatements($graphIri, array $statementsArray, array $options = array());
    
	/**
     * @param string $graphUri
     * @param string $subject (IRI or blank node)
     * @param string $predicate (IRI, no blank node!)
     * @param string $object (IRI, blank node or literal)
     * @param array $options It is possible to disable automatic escaping special
     * characters (like \n) whith the option: "escapeLiteral" and the possible values true and false.
     * 
     * @throws Erfurt_Exception Throws an exception if adding of statements fails.
     */
	public function addStatement($graphUri, $subject, $predicate, $object, array $options = array());
	
	/**
     * 
     * @param string $modelIri
     * @param mixed $subject (string or null)
     * @param mixed $predicate (string or null)
     * @param mixed $object (string or null)
     * @param array $options
     * 
     * @throws Erfurt_Exception
     */
	public function deleteMatchingStatements($modelIri, $subject, $predicate, $object, array $options = array());
	
    /**
     * Deletes statements in an array from the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array  $statementsArray
     */
    public function deleteMultipleStatements($graphIri, array $statementsArray);
	
	/**
	 * @param string $modelIri The Iri, which identifies the model.
	 * 
	 * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
	public function deleteModel($modelIri);
	
	/**
	 * 
	 * @param string $modelIri
	 * @param string $serializationType One of:
	 *                                          - 'xml'
	 *                                          - 'n3' or 'nt'
	 * @param mixed $filename Either a string containing a absolute filename or null. In case null is given,
	 * this method returns a string containing the serialization.
	 * 
	 * @return string/null
	 */
	public function exportRdf($modelIri, $serializationType = 'xml', $filename = null);
	
	/**
	 * @return array Returns an associative array, where the key is the URI of a graph and the value
     * is true.
	 */
	public function getAvailableModels();
	
	/**
	 * Returns the prefix used by the store to identify blank nodes.
	 *
	 * @return string
	 */
    public function getBlankNodePrefix();

	/**
	 * @param string $modelIri The IRI, which identifies the model.
	 * @param boolean $useAc Whether to use access control or not.
	 * 
	 * @throws Erfurt_Exception Throws an exception if model is not available.
	 * 
	 * @return Erfurt_Rdf_Model Returns an instance of Erfurt_Rdf_Model or one of its subclasses.
	 */
	public function getModel($modelIri);
	
	/**
	 * @param string $modelIri
	 * @param string $baseIri
	 * @param string $type
	 * @param boolean $useAc
	 * 
	 * @throws Erfurt_Exception
	 * 
	 * @return Erfurt_Rdf_Model
	 */
	public function getNewModel($modelIri, $baseIri = '', $type = 'owl');
	
	/**
	 * Returns the formats this store can export.
	 *
	 * @return  array
	 */
	public function getSupportedExportFormats();
	
	/**
	 * Returns the formats this store can import.
	 *
	 * @return  array
	 */
	public function getSupportedImportFormats();
	
	/**
	 * 
	 * @param string $modelIri
	 * @param string $locator Either a URL or a absolute file name.
	 * @param string $type One of: 
	 *                              - 'auto' => Tries to detect the type automatically in the following order:
	 *                                              1. Detect XML by XML-Header => rdf/xml
	 *                                              2. If this fails use the extension of the file
	 *                                              3. If this fails throw an exception
	 *                              - 'xml'
	 *                              - 'n3' or 'nt'
	 * @param boolean $stream Denotes whether $data contains the actual data.
	 * 
	 * @throws Erfurt_Exception 
	 */
	public function importRdf($modelIri, $data, $type, $locator);
	
	/**
	 * This method allows the backend to (re)initialize itself, e.g. when an import was done.
	 */
	public function init();
	
	/**
	 * @param string $modelIri The Iri, which identifies the model to look for.
	 * @param boolean $useAc Whether to use access control or not.
	 * 
	 * @return boolean Returns true if model exists and is available for the user ($useAc === true). 
	 */ 
	public function isModelAvailable($modelIri);
	
	/**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $modelIri
     * @param string $askSparql
     * @param boolean $useAc Whether to check for access control.
     */
	public function sparqlAsk($query);
	
	/**
     * @param string $query A string containing a sparql query
     * @param array $modelIris An additional array of modelIris to query against. If a non empty array is given, the 
     * values in this array will overwrite all FROM and FROM NAMED clauses in the query. If the array contains no 
     * element, the FROM and FROM NAMED is evaluated. If non of them is present, all available models are queried.
     * @param string $resultform Currently supported are: 'plain' and 'xml'
     * @param boolean $useAc Whether to check for access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if query is no string.
     * 
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     */
    public function sparqlQuery($query, $resultform = 'plain');
}

?>

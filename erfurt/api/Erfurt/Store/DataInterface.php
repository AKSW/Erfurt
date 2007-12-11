<?php
/**
 * This interface provides methods, that a store, that represents a data store (or triple store) has to implement.
 *
 * @package store
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
interface Erfurt_Store_DataInterface {
	
	/**
	 * This method take a model uri and deletes the whole model.
	 * 
	 * @param string modelURI The uri of the model, which should be deleted.
	 */
	public function deleteModel($modelURI);
	
	/**
	 * NOT YET IMPLEMENTED AND USED
	 */
	public function executeAdd();
	
	/**
	 * This method executes a find-query on a specific model. The $s, $p and $o parameters are used in order to
	 * determine the result set.
	 * 
	 * @param Model $model The model, where to search for matching triples.
	 * @param Resource/null $s A specific subject or null in order to match all subjects.
	 * @param Resource/null $p A specific predicate or null in order to match all predicates.
	 * @param Node/null $o A specific object or null in order to match all objects.
	 * @param boolean $distinct (default: true) Whether to return only distinct values (objects)
	 * @param boolean $sR Iff no subject is given, whether to check uri-subjects.
	 * @param boolean $sB Iff no subject is given, whether to check blanknode-subjects.
	 * @param boolean $oR Iff no object is given, whether to check uri-objects.
	 * @param boolean $oB Iff no object is given, whether to check blanknode-objects.
	 * @param boolean $oL Iff no object is given, whether to check literal-objects.
	 * @param int $offset An optional offset.
	 * @param int $limit This optional parameter limits the result by $limit.
	 * @return Statement[] Returns a list of Statements objects.
	 */
	public function executeFind(Model $m, Resource $s = null, Resource $p = null, Node $object = null, $distinct = true,
						$sR = true, $sB = true, $oR = true, $oB = true, $oL = true, $offset = 0, $limit = -1);
	
	/**
	 * This method executes a find-query on a specific model. The $p and $o parameters are used in order to
	 * determine the result set. The $sType parameter specifies of which additional type the all subjects have to be.
	 * That means, every matchign statement has a subject, that has an additional rdf:type definition with $sType as
	 * object.
	 * 
	 * @param Model $model The model, where to search for matching triples.
	 * @param Resource $sTyoe The type, of which all matching subjects have to be (additional).
	 * @param Resource/null $p A specific predicate or null in order to match all predicates.
	 * @param Node/null $o A specific object or null in order to match all objects.
	 * @param boolean $distinct (default: true) Whether to return only distinct values (objects)
	 * @param boolean $sR Whether to check uri-subjects.
	 * @param boolean $sB Whether to check blanknode-subjects.
	 * @param boolean $oR Iff no object is given, whether to check uri-objects.
	 * @param boolean $oB Iff no object is given, whether to check blanknode-objects.
	 * @param boolean $oL Iff no object is given, whether to check literal-objects.
	 * @param int $offset An optional offset.
	 * @param int $limit This optional parameter limits the result by $limit.
	 * @return Statement[] Returns a list of Statements objects.
	 */
	public function executeFindOnMatchingSubjectType(Model $m, Resource $sType, Resource $p = null, 
						Node $o = null, $distinct = true, $sR = true, $sB = true, $oR = true, $oB = true, $oL = true,
						$offset = 0, $limit = -1);
	
	/**
	 * NOT YET IMPLEMENTED AND USED
	 */
	public function executeRemove();
	
	/**
	 * Returns an instance of Model iff the model identified by the given uri exists and is readable.
	 * 
	 * @param string $modelURI The uri that identifies the model.
	 * @param string[] (default: array()) $importedURIs a list of owl:imports uris that the given model imports.
	 * @param boolean $useACL (default: true) Whether to use acl or not.
	 * @return Model/boolean Returns an instance of Model or false in case the model does not exist or is not 
	 * accessible.
	 */
	public function getModel($modelURI); // rap compatibility
	#public function getModel($modelURI, $importedURIs = array(), $useACL = true);
	
	/**
	 * Returns a new model with the given uri, iff the model does not exist.
	 * 
	 * @param string $modelURI The uri for the new model.
	 * @param string $baseURI An optional base uri, that is used as a prefix for new resource uris in the model.
	 * @param string $type (default: 'RDFS') The type of the new model... one of: 'RDFS' or 'OWL'
	 * @param boolean $useACL (default: true) Whether to use acl or not.
	 * @return Model/boolean Returns an instance of Model or false in case the model already exists or is not 
	 * accessible.
	 */
	public function getNewModel($modelURI, $baseURI = ''); // rap compatibility
	#public function getNewModel($modelURI, $baseURI = '', $type = 'RDFS', $useACL = true);
	
	/**
	 * Returns a list of accessible models.
	 * 
	 * @param boolean (default: false) $returnAsArray Iff true is given, an associative array with model uri as key is
	 * returned, wherer eache element contains the keys modelURI, baseURI (and optional label iff $withLabel = true).
	 * The value of each key is a simple string. Otherwise an associative array with model uri as key is contained,
	 * where the values is an instance of Model.
	 * @param boolean (default: false) $withLabel Whether to return a label (a rdfs:label statement has to exist). This
	 * only has an effect, if $returnAsArray is set to true.
	 * @return String[<MODELURI>][<MODELURI>,<BASEURI>(,<LABEL>)]/Model[<MODELURI>] Returns a list of all available
	 * models as strings or as Model-objects.
	 */
	public function listModels(); // rap compatibility
	#public function listModels($returnAsArray = false, $withLabel = false);
	
	/**
	 * Loads a new model an returns it.
	 *
	 * @param $modelURI The uri for the new model.
	 * @param string/null $file A string that identifies the file or data. 
	 * @param boolean (default: false )$loadImports Wheter to load all owl:imports uris, too. (This uris must be
	 * accessible over the given uri).
	 * @param boolean (default: false) $stream Whether $file contains the data itself (is a stream) or not.
	 * @param string/null $filetype An optional filetype (e.g. rdf or n3).
	 * @return Model/boolean Returns the the new model or false, if something went wrong.
	 */
	public function loadModel($modelURI, $file = NULL, $loadImports = false, $stream = false, $filetype = NULL);
	
	/**
	 * Checks if the model with the given model uri exists or not.
	 *
	 * @param string $modelURI The uri of the model to look for.
	 * @param boolean (default: true) $useACL Whether to use acl or not.
	 * @return  boolean Returns true iff the given model exists, else false.
	 */
	public function modelExists($modelURI); // rap compatibility
	#public function modelExists($modelURI, $useACL = true);
}
?>

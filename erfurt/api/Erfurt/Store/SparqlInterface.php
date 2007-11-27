<?php
/**
  * Defines an interface a store adapter must implement in order to provide
  * sparql capabilities.
  *
  * @package store
  * @author Norman Heino <norman.heino@googlemail.com>
  * @author Philipp Frischmuth <philipp@frischmuth24.de>
  * @version $Id$
  */
interface Erfurt_Store_SparqlInterface {	
	
	/**
	 * This method takes a SPARQL-query and executes it against a given model or against all available models, iff no 
	 * model is given. It is also possible to return instances of specific php classes, specified by the $class param. 
	 * If an additional SparqlEngineDb_ResultRenderer instance is given, the result is converted into the format given
	 * by the result renderer. By default (i.e. without additional $renderer param) this method returns an array 
	 * containing the result-rows and the bindings as an associative array, with the name of the variable as key. 
	 *
	 * @param array|Erfurt_Owl_Model/null $model The model against which the query should be executed.
	 * @param string/Query $query The query, either a string or an instance of Query.
	 * @param string/null $class A string representing a php class (e.g. 'class' for Erfurt_Owl_Class/RDFSClass)
	 * @param SparqlEngineDb_ResultRenderer/null $renderer An optional SparqlEngineDb_ResultRenderer object, in order to
	 * render the result in a specific way.
	 * @param boolean/null $useImports Whether to user owl:imports on owl models or not. (default is false)
	 * @return Resource[][] Returns an array containing the result-rows and the variable-bindings (can be modified by an
	 * optional SparqlEngineDb_ResultRenderer object) 
	 */
	public function executeSparql($model = null, $query, $class = null, $renderer = null, $useImports = false);
}
?>

<?php

/*
 * Interface for Sparql-Endpoint Tests
 */
$endpoint = new Erfurt_Sparql_Endpoint_HTTP();
$q = $_GET['query'];
$endpoint -> setQuery($q);
$endpoint -> query();

/**
 * HTTP-Endpoint-class for the RDF protocol from http://www.w3.org/TR/rdf-sparql-protocol/
 * setting up on Erfurt-API
 * 
 * @author Christoph Rieß
 * 
 **/
class Erfurt_Sparql_Endpoint_HTTP {
	
	/**
	 * Attribute for storing query string
	 */
	private $query;
	
	/**
	 * Attribute for storing allowed Model Ids
	 */
	private $modelIds;
	
	/**
	 * TODO Doc
	 */
	private $queryresult;
	
	/**
	 * TODO Doc
	 */
	private $httpsettings;
	
	/**
	 * TODO Doc
	 */
	private $DBStore;
	
	/**
	 * TODO Doc
	 */
	public function Erfurt_Sparql_Endpoint_HTTP ($query = '') {

		require_once './../../erfurt.php';
		
		error_reporting(E_ERROR);
		
		$erfurt = new Erfurt_App_Default($config);		
		
		$this -> DBStore = $erfurt->getStore();
		
		$this -> query = $query;
		
		foreach ($this->DBStore->listModels() as $m)
			$this -> modelIds[] = $m->getModelId();

	/*
		// Setting Content-Type as specified from W3

		header ('Content-Type: application/sparql-results+xml');
	*/
		
	}
	
	/**
	 * TODO Doc
	 */
	public function setQuery($query) {
		$this -> query = $query;
	}
	
	/**
	 * TODO Doc
	 */
	public function query() {
		if ($query != '')
		return $this -> queryresult = $this -> DBStore -> sparqlQuery($this -> query,$this -> modelIds,"XML");
	}
	
	/**
	 * TODO Doc
	 */
	public function getQueryResult() {
		return $this -> queryresult;
	}
}

?>
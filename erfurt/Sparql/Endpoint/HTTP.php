<?php

/*
 * Interface for Sparql-Endpoint Tests
 */
$endpoint = new Erfurt_Sparql_Endpoint_HTTP();
echo $endpoint -> query();

/**
 * HTTP-Endpoint-class for the SPARQL Protocol for RDF from http://www.w3.org/TR/rdf-sparql-protocol/
 * basing up on Erfurt-API
 * 
 * @author Christoph Rieß
 * TODO HTTP AUTH Support/Login
 * TODO SBAC (for Viewing statements) Support
 * TODO HTTP $_POST Support
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
		
		$this -> query = $query;
		
		$user = '';
		
		$password = '';
		
		if (sizeof($_GET) != 0) {
			if (array_key_exists('query',$_GET))
				$this -> query = $_GET['query'];
			if (array_key_exists('user',$_GET))
				$user = $_GET['user'];
			if (array_key_exists('password',$_GET))
				$password = $_GET['password'];
		}
		
		$erfurt = new Erfurt_App_Default($config,$user,$password);		
		
		$this -> DBStore = $erfurt->getStore();
		
		
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
		if ($this -> query != '')
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
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
	 * Storing query result as string formed in XML
	 */
	private $queryresult;
	
	/**
	 * Storing some http header settings (unused yet)
	 */
	private $httpsettings;
	
	/**
	 * Referencing the Database Store Object to perform SPARQL-Queries on
	 */
	private $DBStore;
	
	/**
	 * Constructor for new Endpoint reading GET/POST Variables for needed values
	 */
	public function Erfurt_Sparql_Endpoint_HTTP ($query = '') {
		
		require_once './../../erfurt.php';
		
		//check if endpoint is enabled else throw exception
		if (!$config->endpoint->http)
			throw new Erfurt_Exception('Endpoint (HTTP) disabled in erfurt-config');
		
		// To surpress warnings
		error_reporting(E_ERROR);
		
		$this -> query = $query;
		
		$model = '';
		
		$user = '';
		
		$password = '';
		
		if (sizeof($_GET) != 0) {
			if (array_key_exists('query',$_GET))
				$this -> query = $_GET['query'];
			if (array_key_exists('user',$_GET))
				$user = $_GET['user'];
			if (array_key_exists('password',$_GET))
				$password = $_GET['password'];
			if (array_key_exists('model',$_GET))
				$model = $_GET['model'];
		}
		
		if (sizeof($_POST) != 0) {
			if (array_key_exists('query',$_POST))
				$this -> query = $_POST['query'];
			if (array_key_exists('user',$_POST))
				$user = $_POST['user'];
			if (array_key_exists('password',$_POST))
				$password = $_POST['password'];
			if (array_key_exists('model',$_POST))
				$model = $_POST['model'];
		} 
		
		if ($this -> query == '') {
			throw new Erfurt_Exception('missing parameters in GET/POST');
		}
		
		$erfurt = new Erfurt_App_Default($config);
		
		// Some functions in erfurt missing this variable?? Not in erfurt.php;
		Zend_Registry::set('strings','');
		
		// Only authenticate if username isn't empty
		if ($user != '')
			$identity = $erfurt -> authenticate($user,$password)-> getIdentity();
			
		if ($identity['uri'] == '' && $user != '') {
			throw new Erfurt_Exception('invalid login (user and/or password)');
		}
		
		// Setting DBStore for interactions with DB
		$this -> DBStore = $erfurt->getStore();
		
		if ($model != '') {
			$m = $this -> DBStore -> getModel($model);
			if ($m != null) {
			$this -> modelIds[] = $m->getModelIds();
			} else {
				throw new Erfurt_Exception('model restricted/not existing');
			}
		} else {
		foreach ($this->DBStore->listModels() as $m)
			$this -> modelIds[] = $m->getModelId();
		}

	/*
		// Setting Content-Type as specified from W3

		header ('Content-Type: application/sparql-results+xml');
	*/
		
	}
	
	/**
	 * Method to set a new query or alter an existing (just setting the query string)
	 */
	public function setQuery($query) {
		$this -> query = $query;
	}
	
	/**
	 * Performing query on DBStore returning xml-result string
	 */
	public function query() {
		return $this -> queryresult = $this -> DBStore -> sparqlQuery($this -> query,$this -> modelIds,"XML");
	}
	
	/**
	 * Getting the result (xml-string)
	 */
	public function getQueryResult() {
		return $this -> queryresult;
	}
}

?>
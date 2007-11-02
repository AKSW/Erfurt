<?php

/*
 * Example usage of HTTP-Endpoint for SPARQL
 */
try {
	$endpoint = new Erfurt_Sparql_Endpoint_HTTP();
	echo $endpoint -> query();
} catch (Exception $e) {
	echo 'Erfurt-Message: ' . $e->getMessage() .  ' / Erfurt-Code: ' . $e->getCode();
}

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
	 * Attribute is array for storing allowed Models
	 */
	private $modelURIs;
	
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
	 * String to store the renderer-name to use for the query
	 *
	 * @var unknown_type
	 */
	private $strRenderer;
	
	/**
	 * Constructor for new Endpoint reading GET/POST Variables for needed values
	 */
	public function Erfurt_Sparql_Endpoint_HTTP ($query = '') {
		
		require_once './../../erfurt.php';
		
		//check if endpoint is enabled else throw exception
		if (!$config->endpoint->http)
			throw new Erfurt_Exception('QueryRequestRefused: Endpoint (HTTP) disabled in erfurt-config',1602);
		
		// To surpress warnings
		//error_reporting(E_ERROR);
		
		$this -> query = $query;
		
		$model = '';
		
		$user = '';
		
		$password = '';
		
		//default renderer should by XML
		$this -> strRenderer = 'XML';
		
		if (sizeof($_GET) != 0) {
			if (array_key_exists('query',$_GET))
				$this -> query = $_GET['query'];
			if (array_key_exists('user',$_GET))
				$user = $_GET['user'];
			if (array_key_exists('password',$_GET))
				$password = $_GET['password'];
			if (array_key_exists('model',$_GET))
				$model = $_GET['model'];
			if (array_key_exists('renderer',$_GET))
				$this -> strRenderer = $_GET['renderer'];
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
			if (array_key_exists('renderer',$_POST))
				$this -> strRenderer = $_POST['renderer'];
		}
		
		if ($this -> query == '') {
			throw new Erfurt_Exception('QueryRequestRefused: missing parameters in GET/POST',1602);
		}
		
		$erfurt = new Erfurt_App_Default($config);
		
		// Some functions in erfurt missing this variable?? Not in erfurt.php;
		Zend_Registry::set('strings','');
		
		// Only authenticate if username isn't empty
		if ($user != '')
			$identity = $erfurt -> authenticate($user,$password)-> getIdentity();
			
		if ($identity['uri'] == '' && $user != '') {
			throw new Erfurt_Exception('QueryRequestRefused: invalid login (user and/or password)',1602);
		}
		
		// Setting DBStore for interactions with DB
		$this -> DBStore = $erfurt->getStore();
		
		// Check if specific model is wanted or all models allowed for current user are used
		// Howto query on multiple models with given sparql engine (in Erfurt)??
		
		/*if (($this -> modelURIs[] = $this -> DBStore -> getModel($model)->getBaseURI()) == NULL)
			throw new Erfurt_exception('QueryRequestRefused: Invalid Model specified for Query',1602);*/
		if ($model != '') {

			if($m = $this->DBStore->getModel($model)) {

				$this -> modelURIs[] = $m->getBaseURI();
			} else {
				throw new Erfurt_Exception('QueryRequestRefused: invalid model',1602);
			}
			
		} else {
			;
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
		
		try {
			$this -> queryresult = $this -> DBStore->executeSparql($this->modelURIs,$this->query,null,$this->strRenderer);				
		} catch (Exception $e) {	
			header('HTTP/1.1 400 Bad Request');
			throw new Erfurt_Exception('Sparql execution error: ' . $e->getMessage(),1601);	
		}
		
		return $this -> queryresult;
	}
	
	/**
	 * Getting the result (xml-string)
	 */
	public function getQueryResult() {
		return $this -> queryresult;
	}
}

?>
<?php

/*
 * <Example>


// Just loading the settings from GET/POST
if (sizeof($_GET) != 0) {
			if (array_key_exists('query',$_GET))
				$query = $_GET['query'];
			if (array_key_exists('user',$_GET))
				$user = $_GET['user'];
			if (array_key_exists('password',$_GET))
				$password = $_GET['password'];
			if (array_key_exists('model',$_GET))
				$model = $_GET['model'];
			if (array_key_exists('renderer',$_GET))
				$renderer = $_GET['renderer'];
}
		
if (sizeof($_POST) != 0) {
			if (array_key_exists('query',$_POST))
				$query = $_POST['query'];
			if (array_key_exists('user',$_POST))
				$user = $_POST['user'];
			if (array_key_exists('password',$_POST))
				$password = $_POST['password'];
			if (array_key_exists('model',$_POST))
				$model = $_POST['model'];
			if (array_key_exists('renderer',$_POST))
				$renderer = $_POST['renderer'];
}


try {	
	$endpoint = new Erfurt_Sparql_Endpoint_HTTP();
	$endpoint->authenticate($user,$password);
	$endpoint->setModel($model);
	$endpoint->setQuery($query);
	$endpoint->setRenderer($renderer);

	echo $endpoint -> query();
	
} catch (Exception $e) {
	
	echo 'Erfurt-Message: ' . $e->getMessage() .  ' / Erfurt-Code: ' . $e->getCode();
	
}


 * </Example>
 */


/**
 * HTTP-Endpoint-class for the SPARQL Protocol for RDF from http://www.w3.org/TR/rdf-sparql-protocol/
 * basing up on Erfurt-API
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
	 * Attribute to check if imports are wanted
	 */
	private $useImports;
	
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
	 * Holding Erfurt_Default_App Instance
	 *
	 * @var unknown_type
	 */
	private $erfurt;
	
	/**
	 * Constructor for new Endpoint reading GET/POST Variables for needed values
	 * @param string $query Sparql Query
	 */
	public function Erfurt_Sparql_Endpoint_HTTP ($query = '') {
		
		require_once './../../erfurt.php';
		
		// use ontowiki settings if available
		$session = new Zend_Session_Namespace('ERFURT');
		
		if (isset($session->config)) {
			$this -> erfurt = new Erfurt_App_Default($session->config);
		} else {
			$this -> erfurt = new Erfurt_App_Default($config);
		}
		
		//check if endpoint is enabled else throw exception
		if (!$config->endpoint->http)
			throw new Erfurt_Exception('QueryRequestRefused: Endpoint (HTTP) disabled in erfurt-config',1602);
		
		// To surpress warnings
		//error_reporting(E_ERROR);
		
		$this -> useImports = false;
		
		$this -> query = $query;
		
		//default renderer should by XML
		$this -> strRenderer = 'XML';
		
		// Some functions in erfurt missing this variable?? Not in erfurt.php;
		Zend_Registry::set('strings','');
		
		// Setting DBStore for interactions with DB
		$this -> DBStore = $this -> erfurt-> getStore();
		
	/*
		// Setting Content-Type as specified from W3

		header ('Content-Type: application/sparql-results+xml');
	*/
		
	}
	
	/**
	 * Setting special model to execute query on.
	 *
	 * @param unknown_type $modeluri
	 */
	public function setModel($modeluri) {
			if ($modeluri === null)
				$this->modelURIs = null;
			else {
				if ($this->DBStore->aclCheck('view',$modeluri) && $this->DBStore->modelExists($modeluri)) {
					$this->modelURIs[] = $modeluri;
				} else {
					throw new Erfurt_Exception('QueryRequestRefused: invalid model',1602);
				}
			}
	}
	
	/**
	 * Doing authentication
	 *
	 * @param unknown_type $user
	 * @param unknown_type $pass
	 */
	public function authenticate($user, $password) {
		
		if (isset($user) && $user != '' ) {
			$authResult = $this->erfurt->authenticate($user,$password);
			$identity = $authResult->getIdentity();
			
			if ($identity['uri'] == '' ) {
				throw new Erfurt_Exception('QueryRequestRefused: invalid login (user and/or password)',1602);
			}
		}
	}
	
	/**
	 * Enable to auto-query on imported model too. 
	 *
	 * @param boolean $userImports
	 */
	public function setUseImports($useImports = false) {
		$this->useImports = $useImports;
	}
	
	/**
	 * Setting renderer as string
	 *
	 * @param string $renderer
	 */
	public function setRenderer($renderer) {
		if ($renderer != '' && $renderer !== null)
			$this->strRenderer = $renderer;
	}
	
	/**
	 * Method to set a new query or alter an existing (just setting the query string)
	 * @param string $query
	 */
	public function setQuery($query) {
		if ($query === null) {
			throw new Erfurt_Exception('QueryRequestRefused: query is empty',1602);
		}
		
		$this -> query = $query;
	}
	
	/**
	 * Performing query on DBStore returning result
	 * 
	 * @return string|array|object result with type varying from which renderer has been choosen
	 */
	public function query() {
		
		try {
			//header('Content-Type: text/'.strtolower($this->strRenderer));
			$this -> queryresult = $this -> DBStore -> executeSparql($this->modelURIs,$this->query,null,$this->strRenderer,$this->useImports);				
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
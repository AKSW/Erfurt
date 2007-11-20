<?php

/**
 * Endpoint-class for the SPARQL Protocol for RDF from http://www.w3.org/TR/rdf-sparql-protocol/
 * basing up on Erfurt-API
 * 
 * @author Christoph Rieß
 * @version $Id$
 * @package sparql
 **/
class Erfurt_Sparql_Endpoint_Default {
	
	/**
	 * Attribute for storing query string
	 * 
	 * @var string the query
	 */
	private $query;
	
	/**
	 * Attribute signaling if queries should be automatically extended to the imported models
	 * 
	 * @var boolean
	 */
	private $useImports;
	
	/**
	 * Attribute is array for storing allowed Models
	 * 
	 * @var array holding the modeluris to query on as strings
	 */
	private $modelURIs;
	
	/**
	 * Storing query result as string|array|object depending on which renderer has been specified
	 * 
	 * @var string|array|object the query result
	 */
	private $queryresult;
	
	/**
	 * Referencing the Database Store Object to perform SPARQL-Queries on
	 * 
	 * @var object Holding reference on the store to query on.
	 */
	private $DBStore;

	/**
	 * String to store the renderer-name to use for the query
	 *
	 * @var string renderer to use
	 */
	private $strRenderer;
	
	/**
	 * Holding Erfurt_Default_App Instance
	 *
	 * @var Erfurt_App_Default the default class to work on
	 */
	private $erfurt;
	
	/**
	 * Constructor for new Endpoint, using given configuration to established 
	 * connection to store and query on it.
	 * 
	 * @param Erfurt_Config $config Sparql Query
	 */
	public function Erfurt_Sparql_Endpoint_Default ($config = null) {
		
		//Load default config from erfurt.ini
		if ($config === null || !is_object($config))
			require (dirname(__FILE__) . '/../../erfurt.php');

		$this -> erfurt = new Erfurt_App_Default($config);
		
		//check if endpoint is enabled throwing exception if not exception
		if (!$config->endpoint->http) {
			header('HTTP/1.0 400 Bad Request');
			throw new Erfurt_Exception('QueryRequestRefused: SPARQL Endpoint disabled in erfurt-config',1602);
		}
		
		// To surpress warnings
		//error_reporting(E_ERROR);
		
		$this -> useImports = true;
		
		$this -> query = '';
		
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
	 * Adding model to execute query on.
	 *
	 * @param string $modeluri
	 * @return void
	 */
	public function addModel($modeluri) {
			if ($modeluri !== null) {
				if ($this->DBStore->aclCheck('view',$modeluri) && $this->DBStore->modelExists($modeluri)) {
					$this->modelURIs[] = $modeluri;
				} else {
					header('HTTP/1.0 400 Bad Request');
					throw new Erfurt_Exception('QueryRequestRefused: invalid model',1602);
				}
			}
	}
	
	/**
	 * Doing authentication
	 *
	 * @param string $user
	 * @param string $pass
	 * @return void
	 * @throws Erfurt_Exception
	 */
	public function authenticate($user, $password) {

		if (isset($user) && $user != '' ) {
			$authResult = $this->erfurt->authenticate($user,$password);
			$identity = $authResult->getIdentity();
			
			if ($identity['uri'] == '' ) {
				header('HTTP/1.0 400 Bad Request');
				throw new Erfurt_Exception('QueryRequestRefused: invalid login (user and/or password)',1602);
			}
		}
	}
	
	/**
	 * Enable to auto-query on imported model too. 
	 *
	 * @param boolean $userImports
	 * @return void
	 */
	public function setUseImports($useImports = false) {
		$this->useImports = $useImports;
	}
	
	/**
	 * Setting renderer as string
	 *
	 * @param string $renderer
	 * @return void
	 */
	public function setRenderer($renderer) {
		if ($renderer != '' && $renderer !== null)
			$this->strRenderer = $renderer;
	}
	
	/**
	 * Method to set a new query or alter an existing (just setting the query string)
	 * 
	 * @param string $query
	 * @return void
	 */
	public function setQuery($query) {
		try {
			$parser = new SparqlParser();
			$this -> query = $parser -> parse(stripslashes($query));
			foreach ($this -> query ->getFromPart() as $resource) {
				$this -> addModel($resource->uri);
			}
		} catch (Exception $e) {
			header('HTTP/1.1 400 Bad Request');
			throw new Erfurt_Exception('MalformedQuery: ' . $e->getMessage(),1603);
		}
	}
	
	/**
	 * Performing query on DBStore returning result
	 * 
	 * @return string|array|object result with type varying from which renderer has been choosen
	 * @throws Erfurt_Exception
	 */
	public function query() {
		
		try {
			//header('Content-Type: text/'.strtolower($this->strRenderer));
			$this -> queryresult = $this -> DBStore -> executeSparql($this->modelURIs,$this->query,null,$this->strRenderer,$this->useImports);				
		} catch (Exception $e) {	
			header('HTTP/1.1 400 Bad Request');
			throw new Erfurt_Exception('QueryRequestRefused: Sparql Error: ' . $e->getMessage(),1602);	
		}
		
		return $this -> queryresult;
	}
	
	/**
	 * Getting the result (datatype maybe varying on different renderers)
	 * 
	 * @return string|array|object result of sparql-query
	 */
	public function getQueryResult() {
		return $this -> queryresult;
	}
}

?>
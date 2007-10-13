<?php

/**
  * RDFS Store Virtuoso Specific Adapter
  * In ordner to by-pass ADO-DB and RDFAPI-PHP, almost every method
  * found in Erfurt_Store_Default is overwritten.
  *
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
class Erfurt_Store_Adapter_Virtuoso extends Erfurt_Store_Default {
	
	/**
	  * Constructs a new Erfurt_Store_Adapter_Virtuoso object.
	  *
	  * @param $dbDriver not used
	  * @param $host not used
	  * @param $dbName Abused to specify the DSN
	  * @param $user Database username
	  * @param $password Database password
	  * @param $sysOntUri URI of the system model
	  * @param $tablePrefix not used
	  */
	public function __construct($dbDriver, $host, $dbName, $user, $password, $sysOntUri = false, $tablePrefix = '') {
		$this->dbDriver  = $dbDriver;
		$this->SysOntURI = $sysOntUri;
		
		try {
			// init fake connection
			$this->dbConn = new FakeAdoConnection($dbName, $user, $password);
		} catch (Exception $e) {
			throw new Erfurt_Exception('Unable to connect to Virtuoso Universal Server via ODBC (vsn: ' . $dbName . ').', 2701);
		}
		
		// old style error handling
		// kept for compatibility reasons
		if (null === $this->dbConn) {
			throw new Erfurt_Exception('Unable to connect to Virtuoso Universal Server via ODBC (vsn: ' . $dbName . ').', 2701);
		}
	}
	
	/**
	  * Destructs the current object and closes open connections (if any).
	  */
	public function __destruct() {
		$this->dbConn->closeConnection();
	}
	
	/**
	  * Initialises the store object.
	  */
	public function init() {
		return $this->isSetup();
	}
	
	/**
	  * Checks whether the store object has already been set up.
	  */
	public function isSetup() {
		// check if connection is set up
		if ($this->dbConn instanceof FakeAdoConnection) {
			$result = $this->dbConn->execute('SELECT COUNT(*) FROM TABLES WHERE TABLE_NAME = \'cache\'');
			@odbc_fetch_row($result);
			
			if (@odbc_result($result, 1)) {
				return true;
			} else {
				throw new Erfurt_Exception('Database Setup: checking for tables &hellip; no tables found.', 1);
			}
		}
	}
	
	public function createTables() {
		$this->_createTables_Virtuoso();
	}
	
	/**
	  * Queries the database using the sparql function DB.DBA.SPARQL_EVAL
	  *
	  * @param $model The graph to be queried
	  * @param $query The sparql query to be executed
	  * @param $class not used
	  */
	public function executeSparql($model, $query, $class = null, $asArray = true) {
		$resultArray    = array();
		$resultRow      = array();
		$resultRowNamed = array();
		
		$result = $this->_getSparqlResult($model, $query);
		
		// get number of fields (columns)
		$numFields = odbc_num_fields($result);
		
		// if we have more results
		// fetch result row into array
		while (odbc_fetch_into($result, $resultRow)) {
			
			// copy column names to array indices
			for ($i = 0; $i < $numFields; ++$i) {
				$resultRowNamed[odbc_field_name($result, $i+1)] = $resultRow[$i];
			}
			
			// add row to result array
			array_push($resultArray, $resultRowNamed);
		}
		
		// Zend_Registry::get('erfurtLog')->debug('Query: ' . $query . ' resulted in ' . count($resultArray) . ' rows.');
		
		return $resultArray;
	}
	
	/**
	  * Returns the result value of a sparql ask query
	  *
	  * @param $query The sparql query
	  * @return boolean
	  */
	public function askSparql($model, $query) {
		$result = $this->_getSparqlResult($model, $query);
		
		if (odbc_result($result, 1) != '0') {
			return true;
		}
		
		return false;
	}
	
	/**
	  * Executes a sparql query.
	  */
	private function _getSparqlResult($model, $query) {
		if (null !== $model) {
			$model = '\'' . $model->modelURI . '\'';
		} else {
			$model = 'NULL';
		}
		
		// query odbc connection
		try {
			$result = $this->dbConn->execute('CALL DB.DBA.SPARQL_EVAL(\'' . $query . '\', ' . $model . ', 0)');
		} catch (Erfurt_Exception $e) {
			throw new Erfurt_Exception('SPARQL Error: ' . $e->getMessage(), 1601);
		}
		
		// return odbc result directly
		return $result;
	}
	
	/**
	  * Returns an array of available graph URIs.
	  * 
	  * @param Returns PHP arrays instead of Model objects
	  * @param $withLabel Returns the model URI along with a rdfs:label literal
	  */
	public function listModels($asArray = false, $withLabel = false) {
		// sparql query to list all distinct named graph URIs along with labels
		$sparql = '
			SELECT DISTINCT ?g, ?l
			WHERE {
				GRAPH ?g {?s ?p ?o.}
				OPTIONAL {?g <' . EF_RDFS_NS . 'label> ?l.}
			}';
		
		$modelArray = array();
		$result = $this->_getSparqlResult(null, $sparql);
		
		while (odbc_fetch_row($result)) {
			$modelUri   = odbc_result($result, 1);
			$modelLabel = odbc_result($result, 2);
			
			// check if view permission is granted
			if ($this->aclCheck('view', $modelUri)) {
				if ($asArray) {
					// return as array
					$modelArray[$modelUri] = array(
						'uri'   => $modelUri, 
						'label' => $modelLabel
					);
				} else {
					// return as model object
					$modelArray[$modelUri] = $this->getModel($modelUri);
				}
			}
		}
		
		return $modelArray;
	}
	
	// /**
	//   * Returns the number available graph URIs.
	//   * 
	//   * @param Returns PHP arrays instead of Model objects
	//   * @param $withLabel Returns the model URI along with a rdfs:label literal
	//   */
	// public function countAvailableModels() {
	// 	$sparql = '
	// 		SELECT COUNT(DISTINCT(?g))
	// 		WHERE {
	// 			GRAPH ?g {?s ?p ?o.}
	// 		}';
	// 		
	// 	// TODO: ACL
	// 	
	// 	// $result = $this->_getSparqlResult(null, $sparql);
	// 	// return odbc_result($result, 1);
	// 	
	// 	return $this->executeSparql(null, $sparql, null, false);
	// }
	
	/**
	  * Checks if a model exists in the database and is viewable.
	  *
	  * @param string $modelUri the model uri to be checked
	  * @param boolean $useAcl enables acl checking 
	  */
	public function modelExists($modelUri, $useAcl = true) {
		$modelExists = false;
		
		if (is_string($modelUri)) {
			// check if graph exists in database
			// $modelExists = $this->askSparql(null, 'ASK WHERE {GRAPH <' . $modelUri . '> {?s ?p ?o.}}');
			$modelExists = odbc_result($this->_getSparqlResult(null, 'ASK WHERE {GRAPH <' . $modelUri . '> {?s ?p ?o.}}'), 1);
			
			// check if graph is viewable according to ACL restrictions
			if ($useAcl && $this->ac instanceof Erfurt_Ac_Default) {
				$modelExists = $modelExists && $this->ac->isModelAllowed('view', $modelUri);
			}
		}
		
		return $modelExists;
	}
	
	/**
	  * Returns an instance of a newly instantiated model object for the given named graph.
	  *
	  * @param string $modelUri the named graph to be instantiated
	  * @param $importedUris
	  * @param boolean $useAcl enables acl checking 
	  */
	public function getModel($modelUri, $importedUris = array(), $useAcl = true) {
		if ($this->modelExists($modelUri, $useAcl)) {
			// TODO: frickel hack for typos
			
			$owlAsk = 'ASK WHERE {GRAPH <' . $modelUri . '> {<' . $modelUri . '> <' . EF_RDF_NS . ':type> <' . EF_OWL_NS . ':Ontology>.}}';
			
			if ($this->executeSparql(null, $owlAsk)) {
				// instantiate owl model
				$model = new Erfurt_Owl_Model($this, $modelUri);
				// TODO: owl imports
			} else {
				// instantiate rdfs model
				$model = new RDFSModel($this, $modelUri);
			}
			
			// TODO: handle owl:imports
			
			if ($model) {
				if ($useAcl && $this->checkAc()) {
					// check if view permission is granted
					if (!$this->ac->isModelAllowed('view', $modelUri)) {
						throw new Erfurt_Exception('Model URI &lt;' . $modelUri . '&gt; not readable by current user.', 1702);
					}
					// set edit permissions
					$model->setEdititable($this->ac->isModelAllowed('edit', $modelUri));
				} else {
					// if no acl, always grant edit permission
					$model->setEdititable(true);
				}
				
				return $model;
			}
		} else {
			throw new Erfurt_Exception('Model URI &lt;' . $modelUri . '&gt; not found in database or not readable.', 1701);
		}
	}
	
	/**
	  * Returns an instance of a newly added named graph.
	  *
	  * @param string $modelUri the named graph to be instantiated
	  * @param $importedUris
	  * @param boolean $useAcl enables acl checking 
	  */
	public function getNewModel($modelUri, $baseUri = '', $type = 'RDFS', $useAcl = true) {
		if (!$this->modelExists($modelUri, false)) {
			if ($type === 'OWL') {
				// add statement (?model rdf:type owl:Ontology)
				$owlIns = 'INSERT INTO GRAPH <' . $modelUri . '> {<' . $modelUri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Ontology>}';
				$this->_getSparqlResult(null, $owlIns);
				
				$model = new Erfurt_Owl_Model($this, $modelUri);
			} else {
				// nothing to do
				$model = new RDFSModel($this, $modelUri);
			}
			
			if ($baseUri != '') {
				$model->baseUri = $baseUri;
			}
		} else {
			throw new Erfurt_Exception('Model already exists.');
		}
		
		return $model;
	}
	
	public function loadModel($modelUri, $file = null, $loadImports = false, $stream = false, $filetype = null) {
		// TODO: load model
	}
	
	/**
	  * Deletes all statements for a given graph from the database.
	  *
	  * @param string $modelUri the named graph's URI
	  */
	public function deleteModel($modelUri) {
		// TODO: remove statements from SysOnt
		$this->_getSparqlResult(null, 'CLEAR GRAPH <' . $modelUri . '>');
	}
	
	/**
	  * Imports statements from a file into a graph.
	  * The file can be in either N3, N-Triples or RDF/XML format.
	  *
	  * @param string $file Path to the file that contains statements.
	  * @param string $type (n3|nt|rdf) 
	  * @param string $graphUri The model URI
	  * @param string $baseUri The base URI
	  */
	public function importStatements($file, $type, $graphUri, $baseUri = '') {
		if (is_readable($file)) {
			if ($type) {
				// check type parameter
				switch (strtolower($type)) {
				case 'n3':	// N3
				case 'nt':	// N-Triple
					$importFunc = 'TTLP';
					break;
				case 'rdf':	// RDF-XML
					$importFunc = 'RDF_LOAD_RDFXML';
					break;
				}
			} else {
				// get path info
				$pathInfo = pathinfo($file);
				// check file extension
				switch ($pathInfo['extension']) {
				case 'n3':	// N3
				case 'nt':	// N-Triple
					$importFunc = 'TTLP';
					break;
				case 'rdf':	// RDF-XML
				default:	// unknown defaults to RDF-XML
					$importFunc = 'RDF_LOAD_RDFXML';
					break;
				}
			}
			// import using internal Virtuoso/PL function
			$importSql = 'CALL DB.DBA.' . $importFunc . '(FILE_TO_STRING_OUTPUT(\'' . $file . '\'), \'' . $baseUri . '\', \'' . $graphUri . '\')';
			$result = $this->dbConn->execute($importSql);
			
			return $result;
		} else {
			throw new Erfurt_Exception('File not readable.', 1704);
		}
	}
	
	/**
	  * Creates additional tables using Virtuoso/SQL.
	  */
	private function _createTables_Virtuoso() {
		// create namespaces table
		$this->dbConn->execute('
			CREATE TABLE namespaces(
				model       IRI_ID NOT NULL, 
				namespace   IRI_ID NOT NULL, 
				prefix      VARCHAR(255) NOT NULL, 
				PRIMARY KEY (model, namespace)
			)');
		
		// create popularity table
		$this->dbConn->execute('
			CREATE TABLE popularity(
				id       INT IDENTITY PRIMARY KEY, 
				date_c   TIMESTAMP NOT NULL, 
				model    IRI_ID NOT NULL, 
				resource IRI_ID NOT NULL
			)');
		
		// create ratings table
		$this->dbConn->execute('
			CREATE TABLE ratings(
				id       INT IDENTITY PRIMARY KEY, 
				model    IRI_ID NOT NULL, 
				user_c   IRI_ID NOT NULL, 
				resource IRI_ID NOT NULL, 
				rating   DECIMAL(1,0) NOT NULL
			)');
		
		// create cache table
		$this->dbConn->execute('
			CREATE TABLE cache(
				id         INT IDENTITY PRIMARY KEY, 
				trigger1   VARCHAR(255) NOT NULL DEFAULT \'\', 
				trigger2   VARCHAR(255) NOT NULL DEFAULT \'\', 
				trigger3   VARCHAR(255) NOT NULL DEFAULT \'\', 
				function_c VARCHAR(255) NOT NULL DEFAULT \'\', 
				args       VARCHAR(255) NOT NULL DEFAULT \'\', 
				model      IRI_ID NOT NULL, 
				resource   IRI_ID NOT NULL, 
				value      LONG VARCHAR NOT NULL
			)');
		
		// TODO: logging tables
		
		// create log_statements table
		
		// create log_actions table
		
		// create log_action_descr table
	}
}


/**
  * A helper class to fake an ADO-DB connection.
  * Since virtuoso runs only through ODBC (with PHP) using ADO-DB makes no 
  * sense in this case.
  * Instead a lightweight helper class is used that maps ADO connection
  * functionality to ODBC API calls.
  */
class FakeAdoConnection {
	
	/**
	  * @var The ODBC connection identifier
	  */
	protected $connection = null;
	
	public function __construct($dbName, $user, $password) {
		// set up odbc connection
		if (!$this->connection = @odbc_connect($dbName, $user, $password)) {
			throw new Erfurt_Exception('ODBC Connection Error: ' . odbc_errormsg());
		}
	}
	
	public function closeConnection() {
		if (null !== $this->connection) {
			@odbc_close($this->connection);
		}
	}
	
	public function execute($sql) {
		// echo 'sql:' . $sql;
		if (!$result = @odbc_exec($this->connection, $sql)) {
			throw new Erfurt_Exception(odbc_errormsg($this->connection));
		}
		
		return $result;
	}
	
	public function getOne($sql) {
		return @odbc_fetch_row($this->execute($sql));
	}
	
	public function getRow($sql) {
		return;
	}
	
	public function getAll($sql) {
		return $this->execute($sql);
	}
	
	public function errorMsg() {
		return @odbc_error($this->connection);
	}
	
	public function startTrans() {
		// TODO
	}
	
	public function completeTrans() {
		// TODO
	}
}

?>

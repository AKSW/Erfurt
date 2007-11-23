<?php
/**
 * Erfurt_Store_Adapter_Rap
 *
 * @package store
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004 - 2007
 * @version $Id$
 */
class Erfurt_Store_Adapter_Rap extends Erfurt_Store_Abstract 
		implements Erfurt_Store_SparqlInterface, Erfurt_Store_SqlInterface {
	
	/**
	 * Constructor:
	 * Set the database connection with the given parameters.
	 *
	 * @param   string   $dbDriver
	 * @param   string   $host
	 * @param   string   $dbName
	 * @param   string   $user
	 * @param   string   $password
	 * @access	public
	 */
	public function __construct($dbDriver, $host, $dbName, $user, $password, $SysOntURI = false, $tablePrefix = '') {
		try {
			@DBStore::DBStore($dbDriver, $host, $dbName, $user, $password);
		} catch (Exception $e) {
			throw new Erfurt_Exception($e->getMessage(), 2701);
		}

		// if 'tablePrefix' is set, attach SQL-rewrite function to store
		if (!empty($tablePrefix)) {
			$this->dbConn->fnExecute = 'pwlRewriteSQL';
		}

		# register for init
		$this->dbDriver = $dbDriver;
		$this->SysOntURI = $SysOntURI;
	}
	
	/**
	 * Create common tables for store
	 */
	public function createTables() {
		$this->_createTables_MySql();
	}
	
	/**
	 * Create tables and indexes for adodb datadict supported databases
	 *
	 * @throws  SqlError
	 * @access	private
	 */
	protected function _createTables_Generic() {
		
		$this->dbConn->startTrans();
		
		$tables = array(
			'models' => array(
				'fields' => '
					modelID		I		NOTNULL	AUTO KEY,
					modelURI	C(255)	NOTNULL,
					baseURI		C(255)	NOTNULL',
				'options'=>'',
				'indexes'=>array('modelURI'),
			),
			'statements'=>array(
				'fields'=>'
					modelID		I		NOTNULL,
					subject		C(255)	NOTNULL,
					predicate	C(255)	NOTNULL,
					object		B,
					l_language	C(255),
					l_datatype	C(255),
					subject_is	C(1)	NOTNULL,
					object_is	C(1)	NOTNULL,
					id			I		NOTNULL	AUTO KEY',
				'options'=>'',
				'indexes'=>array('modelID','subject','predicate','object'),
			),
			'namespaces'=>array(
				'fields'=>'
					modelID		I		NOTNULL AUTO KEY,
					namespace	C(255)	NOTNULL KEY,
					prefix		C(255)	NOTNULL',
				'options'=>'',
				'indexes'=>array(),
			),
			'popularity'=>array(
			    'fields'=>'
			        date        TIMESTAMP       NOT NULL,
			        modelID     INT             NOT NULL,
			        uri         VARCHAR(255)    NOT NULL',
			    'options'=>'',
			    'indexes'=>array(),
			),
			'ratings'=>array(
			    'fields'=>'
			        modelID     INT             NOT NULL,
			        user        VARCHAR(255)    NOT NULL,
			        resource    VARCHAR(255)    NOT NULL,
			        rating      DECIMAL(1,0)    NOT NULL',
			    'options'=>'UNIQUE KEY "modelID" ("modelID", "user", "resource")',
			    'indexes'=>array()
			),
			'cache'=>array(
			    'fields'=>'
			        id          int(11)             NOT NULL auto_increment,
			        trigger1    VARCHAR(255)        NOT NULL DEFAULT "",
			        trigger2    VARCHAR(255)        NOT NULL DEFAULT "",
			        trigger3    VARCHAR(255)        NOT NULL DEFAULT "",
			        function    VARCHAR(255)        NOT NULL DEFAULT "",
			        args        VARCHAR(255)        NOT NULL DEFAULT "",
			        model       INT(11)             NOT NULL DEFAULT "0",
			        resource    VARCHAR(255)        NOT NULL DEFAULT "",
			        value       longblob            NOT NULL',
			    'options'=>'PRIMARY KEY ("id"),
			                UNIQUE KEY "function" ("function", "args", "model", "resource")',
			    'indexes'=>array()
			),
			'log_statements'=>array(
    			'fields'=>'
    				id			INTEGER	AUTO KEY,
    				subject		C(255)	NOTNULL,
    				predicate		C(255)	NOTNULL,
    				object			B,
    				l_language	C(255),
    				l_datatype	C(255),
    				subject_is	C(1)	NOTNULL,
    				object_is	C(1)	NOTNULL,
    				ar			C(1)	NOTNULL,
    				action_id	I		NOTNULL',
    			'options'=>'',
    			'indexes'=>array('action_id'),
    		),
    		'log_actions'=>array(
    			'fields'=>'
    				id			INTEGER	AUTO KEY,
    				parent_id	I,
    				model_id	I		NOTNULL,
    				user		C(255)	NOTNULL,
    				date		T		NOTNULL,
    				descr_id	I		NOTNULL,
    				subject		C(255),
    				details		B',
    			'options'=>'',
    			'indexes'=>array('model_id','parent_id','user'),
    		),
    		'log_action_descr'=>array(
    			'fields'=>'
    				id			INTEGER	AUTO KEY,
    				description	C(255)	NOTNULL',
    			'options'=>'',
    			'indexes'=>array('description'),
    		)
		);
		$dict=NewDataDictionary($this->dbConn, Zend_Registry::get('config')->database->params->type == 'pdo' ? 'db2' : NULL);
#$this->dbConn->execute('connect to POWL;');
		foreach($tables as $tablename=>$table) {
#print_r($dict->CreateTableSQL($tablename,$table['fields'],$table['options']));
			$dict->ExecuteSQLArray($dict->CreateTableSQL($tablename,$table['fields'],$table['options']));
			foreach($table['indexes'] as $indexname=>$index)
				$dict->ExecuteSQLArray($dict->CreateIndexSQL(is_numeric($indexname)?'idx_'.str_replace('_','',$tablename).'_'.strtr($index,array('_'=>'',','=>'')):$indexname,$tablename,$index));
		}
		if (!$this->dbConn->completeTrans())
			echo $this->dbConn->errorMsg();
	}
	
	/**
	 * Create tables and indexes for MySQL databases
	 *
	 */
	
	public function _createTables_MySQL() {
		#$this->_createTables_Generic();
		
		$this->dbConn->startTrans();

		// table: models
		$this->dbConn->execute("CREATE TABLE models (
									modelID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelURI VARCHAR(255) COLLATE ascii_bin NOT NULL, 
									baseURI VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '') ENGINE MyISAM");
								
		// index: (unique) modelURI has to be unique
		$this->dbConn->execute('CREATE UNIQUE INDEX m_modelURI_idx ON models (modelURI)');

		// table: statements
		$this->dbConn->execute("CREATE TABLE statements (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelID INT UNSIGNED NOT NULL,
									subject VARCHAR(255) COLLATE ascii_bin NOT NULL,
									predicate VARCHAR(255) COLLATE ascii_bin NOT NULL,
									object LONGTEXT COLLATE utf8_bin,
									l_language CHAR(2) COLLATE ascii_general_ci DEFAULT '',
									l_datatype VARCHAR(255) COLLATE ascii_bin DEFAULT '',
									subject_is ENUM('r','b') COLLATE ascii_general_ci NOT NULL,
									object_is  ENUM('r','b','l') COLLATE ascii_general_ci NOT NULL) ENGINE MyISAM");

		// table: namespaces
		$this->dbConn->execute("CREATE TABLE namespaces (
									modelID bigint NOT NULL,
		                            namespace varchar(255) NOT NULL,
		                            prefix varchar(255) NOT NULL,
		   							primary key (modelID,namespace)) ENGINE MyISAM");
		
		// indices for statements table
		$this->dbConn->execute('CREATE INDEX s_modelID_idx ON statements (modelID)');
		$this->dbConn->execute('CREATE INDEX s_subject_idx ON statements (subject)');
		$this->dbConn->execute('CREATE INDEX s_predicate_idx ON statements (predicate)');
		$this->dbConn->execute('CREATE INDEX s_object_idx ON statements (object(50))');
		$this->dbConn->execute('CREATE INDEX s_sub_pred_idx ON statements (subject,predicate)');
		$this->dbConn->execute('CREATE INDEX s_pred_obj_idx ON statements (predicate,object(50))');
		$this->dbConn->execute('CREATE INDEX s_sub_obj_idx ON statements (subject,object(50))');
		$this->dbConn->execute('CREATE INDEX s_subjectis_idx ON statements (subject_is)');
		$this->dbConn->execute('CREATE INDEX s_objectis_idx ON statements (object_is)');
		$this->dbConn->execute('CREATE INDEX s_llang_idx ON statements (l_language)');
		$this->dbConn->execute('CREATE INDEX s_ldtype_idx ON statements (l_datatype)');
		
		$this->dbConn->execute('CREATE FULLTEXT INDEX s_object_ft_idx ON statements (object)');
		
		// index: namespaces table
		// are multiple indices ok???
		//$this->dbConn->execute('CREATE INDEX n_modelID_idx ON namespaces (modelID)');

		// table: popularity
		$this->dbConn->execute("CREATE TABLE popularity (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			 						date TIMESTAMP NOT NULL,
									modelID INT UNSIGNED NOT NULL,
									uri VARCHAR(255) COLLATE ascii_bin NOT NULL) ENGINE MyISAM");
								
		// table: ratings
		$this->dbConn->execute("CREATE TABLE ratings (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelID INT UNSIGNED NOT NULL,
									user VARCHAR(255) COLLATE ascii_bin NOT NULL,
									resource VARCHAR(255) COLLATE ascii_bin NOT NULL,
									rating DECIMAL(1,0) NOT NULL) ENGINE MyISAM");
		
		// index: (unique) modelID, user, resource -> a user can only rate one resource in a specific model
		$this->dbConn->execute('CREATE UNIQUE INDEX r_model_user_res_idx ON ratings (modelID,user,resource)');
		
		// table: cache
		$this->dbConn->execute("CREATE TABLE cache (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									trigger1 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									trigger2 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									trigger3 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									function VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									args VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									model INT UNSIGNED NOT NULL DEFAULT 0,
									resource VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									value LONGTEXT COLLATE utf8_bin NOT NULL) ENGINE MyISAM");

		// index: (unique) function, args, model, resource -> must be unique
		$this->dbConn->execute('CREATE UNIQUE INDEX c_func_args_model_res_idx ON cache (function, args, model, resource)');
		
		// table: log_statements
		$this->dbConn->execute("CREATE TABLE log_statements (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									subject VARCHAR(255) COLLATE ascii_bin NOT NULL,
									predicate VARCHAR(255) COLLATE ascii_bin NOT NULL,
									object LONGTEXT COLLATE utf8_bin,
									l_language CHAR(2) COLLATE ascii_general_ci DEFAULT '',
									l_datatype VARCHAR(255) COLLATE ascii_bin DEFAULT '',
									subject_is ENUM('r','b') COLLATE ascii_general_ci NOT NULL,
									object_is  ENUM('r','b','l') COLLATE ascii_general_ci NOT NULL,
									ar CHAR(1) COLLATE ascii_general_ci NOT NULL,
									action_id INT UNSIGNED NOT NULL) ENGINE MyISAM");
		
		// index: action_id
		$this->dbConn->execute('CREATE INDEX logs_action_idx ON log_statements (actionID)');
		
		// table: log_actions
		$this->dbConn->execute("CREATE TABLE log_actions (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									parent_id INT UNSIGNED,
									model_id INT UNSIGNED NOT NULL,
									user VARCHAR(255) COLLATE ascii_bin NOT NULL,
									date DATETIME NOT NULL,
									descr_id INT UNSIGNED NOT NULL,
									subject VARCHAR(255) COLLATE ascii_bin,
									details LONGTEXT COLLATE utf8_bin) ENGINE MyISAM");
		
		// index: model_id, parent_id, user
		$this->dbConn->execute('CREATE INDEX loga_modelid_idx ON log_actions (model_id)');
		$this->dbConn->execute('CREATE INDEX loga_parentid_idx ON log_actions (parent_id)');
		$this->dbConn->execute('CREATE INDEX loga_user_idx ON log_actions (user)');
		
		// table: log_action_descr
		$this->dbConn->execute("CREATE TABLE log_action_descr (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									description VARCHAR(255) COLLATE ascii_general_ci NOT NULL) ENGINE MyISAM");
									
		// index: description
		$this->dbConn->execute('CREATE INDEX logad_descr_idx ON log_action_descr (description(250))');
							
		if (!$this->dbConn->completeTrans()) {
			echo $this->dbConn->errorMsg();
		}
	}
	
	/**
	 *	Implemtation of Sparql-Method for RAP Stores
	 * @param array|OWL-Model $model
	 * @param string/Query $query
	 * @param string/null $class
	 * @param string/null $renderer
	 */
	public function executeSparql($model = null, $query, $class = null, $renderer = null, $useImports = false) {

		// Using all models allowed for current user if no model is specified
		if ($model === null)
			if (sizeof($modellist = $this->listModels(true)) != 0)
				foreach ($modellist as $modeluri)
					$model[] = $modeluri['modelURI'];
			else
				throw new Erfurt_Exception('No models allowed');
			
		//check if AC and Sbac is enabled
		if($this->checkAc()) {
			$Ac = $this->getAc();
			//var_dump($Ac->getSbac());
			if ($Ac->getSbac() != null)
				$Sbac = $Ac->getSbac()->checkAccessRestriction();
		}
		
		$dataset = new DatasetMem();
		
		// Howto SPARQL'l if first parameter is an instance of an Object 'Model'
		if (is_object($model)) {

			$dataset->setDefaultGraph($model);
			$modelIDs[] = $model->getModelID();
			
		}
		
		// and Howto SPARQL'l if first parameter is an array
		if (is_array($model)) {
			foreach($model as $m) {
				//check on model based AC if it is allowed
				if ($this ->modelExists($m) && $this->aclCheck('view',$m) )
					$sqlModelUris .= 'modelURI=\''.$m.'\' OR ';
			}
			$sqlQuery = 'SELECT modelID FROM models WHERE '.$sqlModelUris.' FALSE ';
			foreach ($this->sqlQuery($sqlQuery ) as $ID)
				$modelIDs[] = $ID[0];
		}
		
		// Load IDs of allowed import models
		if ($useImports) {
			
			//Get imported models
			foreach ($modelIDs as $ID) {
				$sqlmodelIDs .= 'modelID = '.$ID . ' OR ';
			}
			$sqlQuery = 'SELECT object FROM statements WHERE ('.$sqlmodelIDs.'FALSE) AND predicate = \'http://www.w3.org/2002/07/owl#imports\'' ;
			
			// Get URIs of allowed models for user
			foreach($this->sqlQuery($sqlQuery) as $m) {
				//check on model based AC if it is allowed
				$sqlModelUris = '';
				if ($this ->modelExists($m[0]) && $this->aclCheck('view',$m[0]) )
					$sqlModelUris .= 'modelURI=\''.$m[0].'\' OR ';
			}
			
			//Now get the IDs
			$sqlQuery = 'SELECT modelID FROM models WHERE '.$sqlModelUris.' FALSE ';
			foreach ($this->sqlQuery($sqlQuery) as $ID) {
				if (!in_array($ID[0],$modelIDs))
					$modelIDs[] = $ID[0];
			}
		}

		$engine = new SparqlEngineDb($this, $modelIDs );
				
		if ($renderer === null)	
			$renderer = new Erfurt_Sparql_ResultRenderer_Default($model, $class);

		if (!($query instanceof Query)) {
				$parser = new SparqlParser();
				$query = $parser->parse($query);
		}
		
		$result = $engine->queryModel($dataset,$query,$renderer);
		
		return $result;
		
	}
	public function sqlQuery($sql) {
		
		$result = $this->dbConn->Execute($sql);
		
		if ($result != null) {
			return $result->getArray();
		} else {
			return null;
		}
	}
	
	/**
	 * This method checks whether a database with the fiven name exists.
	 *
	 * @param string $dbType type of the database (e.g. MySQL)
	 * @param string $dbName name of the database
	 * @return boolean Returns true in case the database exists, false else.
	 */
	public function isDatabaseCreated($dbType="MySQL", $dbName) {
		switch (strtolower($dbType)) {
			case "mysql":
				$db =& $this->dbConn->execute('USE "' . $dbName . '"');
				if (!$db) return false;
				else return true;
		}
	}
	
	/**
	 * returns a list of available and permitted models
	 *   
	 */
	public function listModels($returnAsArray = false, $withLabel = false) {
		$models=array();
		if($ms=DBStore::listModels()) {
			if($returnAsArray) {
				foreach($ms as $model) {
					if($this->aclCheck('View',$model['modelURI'])) {
						if ($withLabel === true) {
							$tempModel = $this->getModel($model['modelURI']);
							$tempResource = $tempModel->resourceF($model['modelURI']);
							$label = $tempResource->getPropertyValue('rdfs:label');
							if ($label) {
								$model['label'] = $label->getLabel();
							}
						}
						
						$models[$model['modelURI']] = $model;
					}
				}
				return $models;
			}
			
			foreach($ms as $model) {
				if($this->aclCheck('View',$model['modelURI']))
					$models[$model['modelURI']]=$this->getModel($model['modelURI']);
			}
		} else
			return $ms;
			
		return $models;
	}
	
	/**
	 * returns instance of an model-object
	 */
	public function getModel($modelURI, $importedURIs=array(), $useACL = true) {
		# get model uri
		$modelURI = is_numeric($modelURI) ? $this->dbConn->getOne('SELECT modelURI FROM models WHERE modelID='.$modelURI) : $modelURI;
		
		# look for model in every uri variation
		ob_start(); // prevent DB error message if tables don't exist
		if(!$this->modelExists($modelURI, $useACL)) {
			if(rtrim($modelURI,'#/') != $modelURI && $this->modelExists(rtrim($modelURI,'#/'), $useACL)) {
				$modelURI=rtrim($modelURI,'#/');
			} else if($this->modelExists($modelURI.'/', $useACL))
				$modelURI.='/';
			else if($this->modelExists($modelURI.'#', $useACL))
				$modelURI.='#';
			else return false;
		}
		$m=new RDFSModel($this,$modelURI);
		ob_end_clean();
		
		
		if($m) {
			if($m->getType()=='OWL') {
				$importedURIs[rtrim($modelURI,'#/')]=rtrim($modelURI,'#/');
				$m=new Erfurt_Owl_Model($this,$modelURI);
				foreach($m->listImports() as $import) if($import instanceof Resource) {
					if(!in_array(rtrim($import->getURI(),'#/'),$importedURIs) && $imp=$this->getModel($import->getURI(),$importedURIs, $useACL))
						$m->importsIds = array_merge($m->importsIds, array($imp->modelID => $imp->modelID), !empty($imp->importsIds) ? $imp->importsIds : array());
					$importedURIs[rtrim($import->getURI(),'#/')]=rtrim($import->getURI(),'#/');
				}
				if($m->importsIds)
					$m->importsSQL=' OR modelID='.join(' OR modelID=',$m->importsIds);
			}
			
			# look for edit possibility
			if ($useACL and $this->checkAc()) {
				if (!$this->ac->isModelAllowed('view', $modelURI)) {
					return false;	
				}
				$m->setEdititable($this->ac->isModelAllowed('edit', $modelURI));
			} else {
				$m->setEdititable(true);
			}
			
			return $m;
		} else
			return false;
	}
	
	
	/**
	 * POWLStore::getNewModel()
	 *
	 * @param $modelURI
	 * @param string $baseURI
	 * @param string $type
	 * @return
	 **/
	public function getNewModel($modelURI,$baseURI='',$type='RDFS', $useACL = true) {
		if($this->modelExists($modelURI, $useACL))
			return false;
		$mt=DBStore::getNewModel($modelURI,$baseURI);
		unset($this->_models[$modelURI]);
		if($type=='OWL')
			$mt->add(new Statement(new resource($modelURI),$GLOBALS['RDF_type'],$GLOBALS['OWL_Ontology']));
		Zend_Registry::set('cache', array());
		$m = $this->getModel($modelURI);
		return $m;
	}
	/**
	 * POWLStore::loadModel()
	 *
	 * @param $modelURI
	 * @param unknown $file
	 * @param boolean $loadImports
	 * @param boolean $stream
	 * @return
	 **/
	public function loadModel($modelURI,$file=NULL,$loadImports=false,$stream=false,$filetype=NULL) {
		static $justLoaded;
		$justLoaded[$modelURI]=true;
		$file=$file?$file:$modelURI;
		if($fp=fopen($file,'rb')) {
			if($this->SysOnt) {
				$head=fread($fp,2000);
				fclose($fp);
				preg_match_all('/xmlns:([^=]+)=[\'"]([^"\']+)[\'"]/im',$head,$matches);
				$i=array_search($modelURI,$matches[2]);
				$name = ($i!==false) ? $matches[1][$i] : $this->SysOnt->getUniqueResourceURI('Modelinstance');
				$modelInst=$this->SysOnt->addInstance($name,'Model');
				$modelInst->setPropertyValue('modelURI',$modelURI);
				foreach($matches[1] as $key=>$val)
					$modelInst->addPropertyValue('modelXMLNS',trim($val).':'.trim($matches[2][$key]));
			}
		} else
			return false;
		$model=$this->getNewModel($modelURI);
		$model->dontCheckForDuplicatesOnAdd=true;
		$model->logStart('Model created',$modelURI);
		$model->logEnd();
	 	$log=$this->logDisabled;
		$model->logDisabled=true;
		if(in_array(strtolower(Zend_Registry::get('config')->database->params->type), array('mysql','mysqli')))
			$this->dbConn->execute('ALTER TABLE statements DISABLE KEYS');
	 	$model->load($file,$filetype,$stream);
		if(in_array(strtolower(Zend_Registry::get('config')->database->params->type), array('mysql','mysqli')))
			$this->dbConn->execute('ALTER TABLE statements ENABLE KEYS');
		$model=$this->getModel($modelURI);
		if($modelInst) {
			$type=$model->getType();
			$modelInst->setPropertyValue('modelType',$type);
		}
		if($type=='OWL' && $loadImports)
			foreach($model->listImports() as $import)
				if($this->modelExists($import->getURI())) {
					if(!$justLoaded[$import->getURI()])
						trigger_error("Imported model \"".$import->getURI()."\" exists!\n",E_USER_WARNING);
				} else {
					pwlOutput("Loading imported model \"".$import->getURI()."\".\n");
					$imp=$this->loadModel($import->getURI(),$import->getURI(),true,$stream);
				}

		$this->logDisabled=$log;
		return $model;
	}
	/**
	 * POWLStore::deleteModel()
	 *
	 * @param $modelURI
	 * @return
	 **/
	public function deleteModel($modelURI) {
		if($this->SysOnt)
			if($mi=$this->SysOnt->getClass('Model'))
				if($inst=$mi->findInstance(array('modelURI'=>$modelURI)))
					$inst->remove();
		$m=$this->getModel($modelURI);
		$m->delete();
		cache('modelExists',array($modelURI),false);
	}
	
	/**
	 * Check if the DbModel with the given modelURI is already stored in the database
	 *
	 * @param   string   $modelURI
	 * @param   boolean  useACL for installation check
	 * @return  boolean
	 * @throws	SqlError
	 * @access	public
	 */
	public function modelExists($modelURI, $useACL = true) {
		$args=func_get_args();
		$c=cache('modelExists',$args);
		if($c!==NULL)
			return $c;
		
		$modelExists = false; 
		if ($modelExists = DBStore::modelExists($modelURI)) {
			if (is_object($this->ac) and method_exists($this->ac, 'isModelAllowed'))
				if ($useACL and !$this->ac->isModelAllowed('view', $modelURI))
					$modelExists = false;
		}
		return cache('modelExists', $args, $modelExists);
	}
	
	public function isSetup() {
		
		if(Zend_Registry::get('config')->database->backend == 'powl')
			return true;
		else  
			return DBStore::isSetup();
	}
	
	public function executeAdd() {}
	public function executeRemove() {}
	public function executeFind() {}
}
?>
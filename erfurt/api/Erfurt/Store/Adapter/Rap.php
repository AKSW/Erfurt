<?php
/**
 * This is an adapter-class for the RAP backend. In this case this means the use of the RAP db scheme and a 
 * relational database accessed via adodb.
 *
 * @package store
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004 - 2007
 * @version $Id$
 */
class Erfurt_Store_Adapter_Rap extends Erfurt_Store_Abstract 
		implements Erfurt_Store_SparqlInterface, Erfurt_Store_SqlInterface, Erfurt_Store_CountableInterface {
	
	/**
	 * Set the database connection with the given parameters.
	 *
	 * @param string $dbDriver A string that identifies the db-driver (e.g. 'mysqli')
	 * @param string $host A string that identifies the host (e.g. 'localhost')
	 * @param string $dbName The name of the database to use.
	 * @param string $user The db-user to use.
	 * @param string $password The password that is used with $user.
	 * @param string $SysOntURI (default: false) An optional uri that identifies the system ontology.
	 * @param string $tablePrefix (default: '') An optional table prefix, that is used in front of every table name.
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
	 * @see Erfurt_Store_SqlInterface
	 */
	public function createTables() {
// TODO check for different backends
		$this->_createTables_MySql();
	}

	/**
	 * This method creates tables and indexes for MySQL databases.
	 * Do not use this method directly, it is only public for compatibility with rap. 
	 *
	 * @access protected
	 */	
	public function _createTables_MySQL() {
		
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
			 						ef_date TIMESTAMP NOT NULL,
									modelID INT UNSIGNED NOT NULL,
									uri VARCHAR(255) COLLATE ascii_bin NOT NULL) ENGINE MyISAM");
								
		// table: ratings
		$this->dbConn->execute("CREATE TABLE ratings (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelID INT UNSIGNED NOT NULL,
									ef_user VARCHAR(255) COLLATE ascii_bin NOT NULL,
									ef_resource VARCHAR(255) COLLATE ascii_bin NOT NULL,
									rating DECIMAL(1,0) NOT NULL) ENGINE MyISAM");
		
		// index: (unique) modelID, user, resource -> a user can only rate one resource in a specific model
		$this->dbConn->execute('CREATE UNIQUE INDEX r_model_user_res_idx ON ratings (modelID,ef_user,ef_resource)');
		
		// table: cache
		$this->dbConn->execute("CREATE TABLE cache (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									trigger1 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									trigger2 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									trigger3 VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									function VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									args VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									model INT UNSIGNED NOT NULL DEFAULT 0,
									ef_resource VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '',
									value LONGTEXT COLLATE utf8_bin NOT NULL) ENGINE MyISAM");

		// index: (unique) function, args, model, resource -> must be unique
		$this->dbConn->execute('CREATE UNIQUE INDEX c_func_args_model_res_idx ON cache (function, args, model, ef_resource)');
		
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
									ef_user VARCHAR(255) COLLATE ascii_bin NOT NULL,
									ef_date DATETIME NOT NULL,
									descr_id INT UNSIGNED NOT NULL,
									subject VARCHAR(255) COLLATE ascii_bin,
									details LONGTEXT COLLATE utf8_bin) ENGINE MyISAM");
		
		// index: model_id, parent_id, user
		$this->dbConn->execute('CREATE INDEX loga_modelid_idx ON log_actions (model_id)');
		$this->dbConn->execute('CREATE INDEX loga_parentid_idx ON log_actions (parent_id)');
		$this->dbConn->execute('CREATE INDEX loga_user_idx ON log_actions (ef_user)');
		
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
	 * Implemtation of Sparql-Method for RAP Stores
	 * 
	 * @see Erfurt_Store_SparqlInterface
	 */
	public function executeSparql($model = null, $query, $class = null, $renderer = null, $useImports = false, $useAcl = true) {

		// Using all models allowed for current user if no model is specified
		if ($model === null) {
			if (sizeof($modellist = $this->listModels(true)) != 0) {
				foreach ($modellist as $modeluri) {
					$model[] = $modeluri['modelURI'];
				}
			} else {
				throw new Erfurt_Exception('No models allowed');
			}
		}
		
		// !!! important
		//check if AC and Sbac is enabled
		if($this->checkAc() and $useAcl) {
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
	
	/**
	 * @see Erfurt_Store_SqlInterface
	 */
	public function sqlQuery($sql) {
		
		$result = $this->dbConn->Execute($sql);
		
		if ($result != null) {
			return $result->getArray();
		} else {
			return null;
		}
	}
	
	/**
	 * @see Erfurt_Store_SqlInterface
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
	 * @see Erfurt_Store_DataInterface
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
	 * @see Erfurt_Store_DataInterface
	 */
	public function getModel($modelURI, $importedURIs=array(), $useACL = true) {

		# get model uri
		$modelURI = is_numeric($modelURI) ? $this->dbConn->getOne('SELECT modelURI FROM models WHERE modelID='.$modelURI) : $modelURI;
		
		# look for model in every uri variation
		#ob_start(); // prevent DB error message if tables don't exist
		if(!$this->modelExists($modelURI, $useACL)) {
			#if(rtrim($modelURI,'#/') != $modelURI && $this->modelExists(rtrim($modelURI,'#/'), $useACL)) {
			#	$modelURI=rtrim($modelURI,'#/');
			#} else if($this->modelExists($modelURI.'/', $useACL))
			#	$modelURI.='/';
			#else if($this->modelExists($modelURI.'#', $useACL))
			#	$modelURI.='#';
			#else return false;
			
			return false;
		}
		$m = new RDFSModel($this, $modelURI);
		#ob_end_clean();
		
		if ($m) {
			if ($m->getType() === 'OWL') {
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
	 * @see Erfurt_Store_DataInterface 
	 * @trigger EFModelAddedEvent
	 */
	public function getNewModel($modelURI,$baseURI='',$type='RDFS', $useACL = true) {
		if($this->modelExists($modelURI, $useACL))
			return false;
		$mt=DBStore::getNewModel($modelURI,$baseURI);
		unset($this->_models[$modelURI]);
		if($type=='OWL')
			$mt->add(new Statement(new resource($modelURI),$GLOBALS['RDF_type'],$GLOBALS['OWL_Ontology']));
		Zend_Registry::set('cache', array());
		$m = $this->getModel($modelURI);
		
		// trigger event
		// TODO
		
		return $m;
	}
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
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
	 * @see Erfurt_Store_DataInterface
	 */
	public function deleteModel($modelURI) {
		#if($this->SysOnt)
		#	if($mi=$this->SysOnt->getClass('Model'))
		#		if($inst=$mi->findInstance(array('modelURI'=>$modelURI)))
		#			$inst->remove();
		$m = $this->getModel($modelURI);
		$m->delete();
		cache('modelExists',array($modelURI),false);
	}
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function modelExists($modelURI, $useACL = true) {
		$args = array($modelURI);

		$c = cache('modelExists', $args);
		if ($c !== null) {
			return $c;
		}
			
		$modelExists = false; 
		if ($modelExists = DBStore::modelExists($modelURI)) {
			if (is_object($this->ac) and method_exists($this->ac, 'isModelAllowed'))
				if ($useACL and !$this->ac->isModelAllowed('view', $modelURI))
					$modelExists = false;
		}
		#return $modelExists;
		return cache('modelExists', $args, $modelExists);
	}
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function isSetup() {
		
		if (Zend_Registry::get('config')->database->backend == 'powl') {
			return true;
		} else {
			return DBStore::isSetup();
		} 
	}
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function executeAdd() {}
// TODO
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function executeRemove() {}
// TODO
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function executeFind(Model $m = null, Resource $s = null, Resource $p = null, Node $o = null, 
						$distinct = true, $sR = true, $sB = true, $oR = true, $oB = true, $oL = true, $offset = 0,
						$limit = -1) {
							
		$sql = 'SELECT subject, subject_is, predicate, object, object_is, l_language, l_datatype 
				FROM ' . $GLOBALS['RAP']['conf']['database']['tblStatements'] . ' WHERE ';
				
		if ($m !== null) {
			$sql .= 'modelID IN (' . join(',', $this->_listModelIDs($m)) . ') AND ';
		}	
				
		if ($s !== null) {
			$sql .= 'subject = "' . $s->getLabel() . '" AND '; 
			
			if ($s instanceof BlankNode) {
				$sql .= 'subject_is = "b" AND ';
			} else {
				$sql .= 'subject_is = "r" AND ';
			}
			
		}
		if ($p !== null) {
			$sql .= 'predicate = "' . $p->getURI() . '" AND ';
		}
		if ($o !== null) {
			$sql .= 'object = "' . $o->getLabel() . '" AND ';
			
			if ($o instanceof Literal) {
				$sql .= 'l_language = "' . $o->getLanguage() . '" AND l_datatype = "' . $o->getDatatype() . 
						'" AND object_is = "l" AND ';
			} else if ($o instanceof BlankNode) {
				$sql .= 'object_is = "b" AND ';
			} else {
				$sql .= 'object_is = "r" AND ';
			}
		}
		
		if ($s === null) {
			$subjectIs = array();
			if ($sR === true) {
				$subjectIs[] = '"r"';
			}
			if ($sB === true) {
				$subjectIs[] = '"b"';
			}
			
			$sql .= 'subject_is IN (' . join(',', $subjectIs) . ') AND ';
		}
		
		if ($o === null) {
			$objectIs = array();
			if ($oR === true) {
				$objectIs[] = '"r"';
			}
			if ($oB === true) {
				$objectIs[] = '"b"';
			}
			if ($oL === true) {
				$objectIs[] = '"l"';
			}
			
			$sql .= 'object_is IN (' . join(',', $objectIs) . ') AND ';
		}
		
		
		// in order to make the code more easy to read... just add a 1 (always true)
		$sql .= '1 ';
		
		if ($distinct === true) {
			$sql .= 'GROUP BY object, object_is, l_language, l_datatype';
		}
		
		return $this->_convertSqlResultToStatementList($this->sqlQuery($sql));
	}
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function executeFindDefiningModels(Resource $s = null, Resource $p = null, Node $o = null, 
						$sR = true, $sB = true, $oR = true, $oB = true, $oL = true) {
	
		$sql = 'SELECT m.modelURI
				FROM models m 
				LEFT JOIN ' . $GLOBALS['RAP']['conf']['database']['tblStatements'] . ' s
				ON (m.modelID = s.modelID)
				WHERE s.modelID IS NOT NULL AND ';

		if ($s !== null) {
			$sql .= 's.subject = "' . $s->getLabel() . '" AND '; 

			if ($s instanceof BlankNode) {
				$sql .= 's.subject_is = "b" AND ';
			} else {
				$sql .= 's.subject_is = "r" AND ';
			}
		}
				
		if ($p !== null) {
			$sql .= 's.predicate = "' . $p->getURI() . '" AND ';
		}
				
		if ($o !== null) {
			$sql .= 's.object = "' . $o->getLabel() . '" AND ';

			if ($o instanceof Literal) {
				$sql .= 's._language = "' . $o->getLanguage() . '" AND s.l_datatype = "' . $o->getDatatype() . 
						'" AND s.object_is = "l" AND ';
			} else if ($o instanceof BlankNode) {
				$sql .= 's.object_is = "b" AND ';
			} else {
				$sql .= 's.object_is = "r" AND ';
			}
		}

		if ($s === null) {
			$subjectIs = array();
					
			if ($sR === true) {
				$subjectIs[] = '"r"';
			}
			if ($sB === true) {
				$subjectIs[] = '"b"';
			}

			$sql .= 's.subject_is IN (' . join(',', $subjectIs) . ') AND ';
		}

		if ($o === null) {
			$objectIs = array();
				
			if ($oR === true) {
				$objectIs[] = '"r"';
			}
			if ($oB === true) {
				$objectIs[] = '"b"';
			}
			if ($oL === true) {
				$objectIs[] = '"l"';
			}

			$sql .= 's.object_is IN (' . join(',', $objectIs) . ') AND ';
		}

		// in order to make the code more easy to read... just add a 1 (always true)
		$sql .= '1 ';

		$result = $this->sqlQuery($sql);
		$resultList = array();
		
		foreach ($result as $row) {
			$resultList[] = $row[0];
		}

		return $resultList;
	}
	
	/**
	 * @see Erfurt_Store_DataInterface
	 */
	public function executeFindOnMatchingSubjectType(Model $m, Resource $sType, Resource $p = null, 
						Node $o = null, $distinct = true, $sR = true, $sB = true, $oR = true, $oB = true, 
						$oL = true, $offset = 0, $limit = -1) {
							
		$subjectIs = array();
		if ($sR === true) {
			$subjectIs[] = '"r"';
		}
		if ($sB === true) {
			$subjectIs[] = '"b"';
		}
	
		$sql = 'SELECT s1.subject, s1.subject_is, s1.predicate, s1.object, s1.object_is, s1.l_language, s1.l_datatype 
				FROM ' . $GLOBALS['RAP']['conf']['database']['tblStatements'] . ' s1
				LEFT JOIN ' . $GLOBALS['RAP']['conf']['database']['tblStatements'] . ' s2
				ON (s1.subject = s2.subject AND s1.subject_is = s2.subject_is AND s2.predicate = "' . EF_RDF_TYPE . '"
				AND s2.object = "' . $sType->getLabel() . '"
				AND s2.modelID IN (' . join(',', $this->_listModelIDs($m)) . '))
				WHERE s1.modelID IN (' . join(',', $this->_listModelIDs($m)) . ') AND
				s2.subject IS NOT NULL AND s1.subject_is IN (' . join(',', $subjectIs) . ') AND ';
		
		if ($p !== null) {
			$sql .= 's1.predicate = "' . $p->getURI() . '" AND ';
		}
		
		if ($o !== null) {
			$sql .= 's1.object = "' . $o->getLabel() . '" AND ';
			
			if ($o instanceof Literal) {
				$sql .= 's1.object_is = "l" AND s1.l_language = "' . $o->getLanguage() . '" AND s1.l_datatype = "' . 
						$o->getDatatype() . '" AND ';
			} else if ($o instanceof BlankNode) {
				$sql .= 's1.object_is = "b" AND ';
			} else {
				$sql .= 's1.object_is = "r" AND ';
			}
		} else {
			$objectIs = array();
			if ($oR === true) {
				$objectIs[] = '"r"';
			}
			if ($oB === true) {
				$objectIs[] = '"b"';
			}
			if ($oL === true) {
				$objectIs[] = '"l"';
			}
			
			$sql .= 's1.object_is IN (' . join(',', $objectIs) . ') AND ';
		}
		
		// in order to make the code more easy to read... just add a 1 (always true)
		$sql .= '1 ';
		
		if ($distinct === true) {
			$sql .= 'GROUP BY s1.object, s1.object_is, s1.l_language, s1.l_datatype';
		}
		
		return $this->_convertSqlResultToStatementList($this->sqlQuery($sql));
	}
	
	/*
	 * Converts an sql result (sqlQuery()) into a list of Statement objects.
	 * 
	 * @param string[][] A string array containing all result rows and columns
	 * @return Statement[] Returns a list of Statement objects.
	 */
	protected function _convertSqlResultToStatementList($result) {
		
		$stmArray = array();
		
		foreach ($result as $row) {
			
			$s = null;
			if ($row[1] === 'b') {
				$s = new BlankNode($row[0]); 
			} else {
				$s = new Resource($row[0]);
			}
			
			$p = new Resource ($row[2]);
			
			$o = null;
			if ($row[4] === 'b') {
				$o = new BlankNode($row[3]);
			} else if ($row[4] === 'l') {
				$o = new Literal($row[3], $row[5], $row[6]);
			} else {
				$o = new Resource($row[3]);
			}
			
			$stmArray[] = new Statement($s, $p, $o);
		}
		
		return $stmArray;
	}
	
	/*
	 * helper function, that returns the modelID for a given modelURI
	 * 
	 * @param string $modelURI The uri of the model.
	 * @return int Returns the id of the model.
	 */
	protected function _getModelID($modelURI) {
		
		$sql = 'SELECT modelID FROM models WHERE modelURI = "' . $modelURI . '"';
		
		return $this->dbConn->getOne($sql);
	}
	
	/*
	 * Returns a list containing all model ids for the given model (model id for the model and all owl:imports models).
	 * 
	 * @param Model $m The model, where to look for the ids.
	 * @return int[] Returns a list of model ids.
	 */
	protected function _listModelIDs(Model $m = null) {
		
		if ($m === null) {
			return array();
		}
		
		$modelIDs = array();
		$modelIDs[] = $this->_getModelID($m->modelURI);
		
		foreach ($m->listImports(true) as $mURI) {
			$modelIDs[] = $this->_getModelID($mURI);
		}
		
		return $modelIDs;
	}
	
	/**
	 * @see Erfurt_Store_CountableInterface
	 */
	public function executeCountValues(Model $model, Resource $subject = null, Resource $predicate = null, 
						$distinct = true, $r = true, $b = true, $l = true) {
		
		$modelIDs = array();
		$modelIDs[] = $this->_getModelID($model->modelURI);
		
		foreach ($model->listImports(true) as $mURI) {
			$modelIDs[] = $this->_getModelID($mURI);
		}
		
		$sql = 'SELECT COUNT(';
		
		if ($distinct === true) {
			$sql .= 'DISTINCT ';
		}
		
		$sql .= 'object, object_is, l_language, l_datatype) FROM ' . 
				$GLOBALS['RAP']['conf']['database']['tblStatements'] . 
				' WHERE modelID IN (' . join(',', $modelIDs) . ') AND ';;
				
		if ($subject !== null) {
			$sql .= 'subject = "' . $subject->getLabel() . '" AND ';
		}
		
		if ($predicate !== null) {
			$sql .= 'predicate = "' . $predicate->getURI() . '" AND ';
		}
		
		$objectIs = array();
		if ($r === true) {
			$objectIs[] = '"r"';
		}
		if ($b === true) {
			$objectIs[] = '"b"';
		}
		if ($l === true) {
			$objectIs[] = '"l"';
		}
		
		$sql .= 'object_is IN (' . join(',', $objectIs) . ')';
		
		return $this->dbConn->getOne($sql);
	}
	
	/**
	 * @see Erfurt_Store_CountableInterface
	 */
	public function executeCountValuesOnMatchingSubjectType(Model $model, Resource $subjectType, 
						Resource $predicate = null, $distinct = true, $r = true, $b = true, $l = true) {
	
		$modelIDs = array();
		$modelIDs[] = $this->_getModelID($model->modelURI);

		foreach ($model->listImports(true) as $mURI) {
			$modelIDs[] = $this->_getModelID($mURI);
		}
		
		$objectIs = array();
		if ($r === true) {
			$objectIs[] = '"r"';
		}
		if ($b === true) {
			$objectIs[] = '"b"';
		}
		if ($l === true) {
			$objectIs[] = '"l"';
		}
		
		$sql = 'SELECT COUNT(';
		
		if ($distinct === true) {
			$sql .= 'DISTINCT ';
		}
		
		$sql .= 's1.object, s1.object_is, s1.l_language, s1.l_datatype) FROM ' . 
				$GLOBALS['RAP']['conf']['database']['tblStatements'] . ' s1 
				LEFT JOIN ' . $GLOBALS['RAP']['conf']['database']['tblStatements'] . ' s2 
				ON (s1.subject = s2.subject AND s2.predicate = "' . EF_RDF_TYPE . '" 
				AND s2.object = "' . $subjectType->getLabel() . '"
				AND s2.modelID IN (' . join(',', $modelIDs) . '))
				WHERE s1.modelID IN (' . join(',', $modelIDs) . ') AND s2.subject IS NOT NULL';
				
		if ($predicate !== null) {
			$sql .= ' AND s1.predicate = "' . $predicate->getURI() . '"';
		}
		
		$sql .= ' AND s1.object_is IN(' . join(',', $objectIs) . ')';
				
		return $this->dbConn->getOne($sql);
	}	
}
?>

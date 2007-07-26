<?php
/**
 * RDFSStore
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: store.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/

class Erfurt_Store_Adapter_Rap extends Erfurt_Store_Default {
	/**
	 * Create tables and indexes for adodb datadict supported databases
	 *
	 * @throws  SqlError
	 * @access	private
	 */
	function _createTables_Generic() {
		$this->dbConn->startTrans();
	#	$this->dbConn->debug=true;
		$tables=array(
			'models'=>array(
				'fields'=>'
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
	function _createTables_MySQL() {
		#$this->_createTables_Generic();
		
		$this->dbConn->startTrans();

		// table: models
		$this->dbConn->execute("CREATE TABLE models (
									modelID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelURI VARCHAR(255) COLLATE ascii_bin NOT NULL, 
									baseURI VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT '')");
								
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
									object_is  ENUM('r','b','l') COLLATE ascii_general_ci NOT NULL)");

		// table: namespaces
		$this->dbConn->execute("CREATE TABLE namespaces (
									modelID bigint NOT NULL,
		                            namespace varchar(255) NOT NULL,
		                            prefix varchar(255) NOT NULL,
		   							primary key (modelID,namespace))");
		
		// indices for statements table
		$this->dbConn->execute('CREATE INDEX s_modelID_idx ON statements (modelID)');
		$this->dbConn->execute('CREATE INDEX s_subject_idx ON statements (subject(200))');
		$this->dbConn->execute('CREATE INDEX s_predicate_idx ON statements (predicate(200))');
		$this->dbConn->execute('CREATE INDEX s_object_idx ON statements (object(250))');
		$this->dbConn->execute('CREATE INDEX s_sub_pred_idx ON statements (subject(200),predicate(200))');
		$this->dbConn->execute('CREATE FULLTEXT INDEX s_object_ft_idx ON statements (object)');
		
		// index: namespaces table
		// are multiple indices ok???
		//$this->dbConn->execute('CREATE INDEX n_modelID_idx ON namespaces (modelID)');

		// table: popularity
		$this->dbConn->execute("CREATE TABLE popularity (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			 						date TIMESTAMP NOT NULL,
									modelID INT UNSIGNED NOT NULL,
									uri VARCHAR(255) COLLATE ascii_bin NOT NULL)");
								
		// table: ratings
		$this->dbConn->execute("CREATE TABLE ratings (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									modelID INT UNSIGNED NOT NULL,
									user VARCHAR(255) COLLATE ascii_bin NOT NULL,
									resource VARCHAR(255) COLLATE ascii_bin NOT NULL,
									rating DECIMAL(1,0) NOT NULL)");
		
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
									value LONGTEXT COLLATE utf8_bin NOT NULL)");

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
									action_id INT UNSIGNED NOT NULL)");
		
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
									details LONGTEXT COLLATE utf8_bin)");
		
		// index: model_id, parent_id, user
		$this->dbConn->execute('CREATE INDEX loga_modelid_idx ON log_actions (model_id)');
		$this->dbConn->execute('CREATE INDEX loga_parentid_idx ON log_actions (parent_id)');
		$this->dbConn->execute('CREATE INDEX loga_user_idx ON log_actions (user)');
		
		// table: log_action_descr
		$this->dbConn->execute("CREATE TABLE log_action_descr (
									id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									description VARCHAR(255) COLLATE ascii_general_ci NOT NULL)");
									
		// index: description
		$this->dbConn->execute('CREATE INDEX logad_descr_idx ON log_action_descr (description(250))');
							
		if (!$this->dbConn->completeTrans()) {
			echo $this->dbConn->errorMsg();
		}
	}
	
	/**
	 *
	 * @param RDFSModel $model
	 * @param string/Query $query
	 * @param string/null $class
	 */
	public function executeSparql($model, $query, $class = null, $renderer = null) {
		
		$engine = new SparqlEngineDb($this, $model->listModelIds());
		
		$dataset = new DatasetMem();
		$dataset->setDefaultGraph($model);
		
		if (!($query instanceof Query)) {
			$parser = new SparqlParser();
			$query = $parser->parse($query);
		}
		
		if ($renderer === null)	$renderer = new Erfurt_Sparql_ResultRenderer_Default($model, $class);
		
		return $engine->queryModel($dataset, $query, $renderer);
	}
	
}
?>
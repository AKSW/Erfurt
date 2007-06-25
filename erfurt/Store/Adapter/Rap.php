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
		$this->_createTables_Generic();
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
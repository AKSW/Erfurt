<?php
/*
 * DefaultPOWLStore.php
 * Encoding: ISO-8859-1
 *
 * Copyright (c) 2006 S�en Auer <soeren@auer.cx>
 *                    Philipp Frischmuth <philipp@frischmuth24.de>
 * 									Stefan Berger <berger@intersolut.de>
 *
 * This file is part of pOWL - web based ontology editor.
 *
 * pOWL is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * pOWL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pOWL; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * DefaultPOWLStore
 *
 * @package rdfsapi
 * @author S�en Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2006
 * @version $Id: store.php 834 2007-03-12 08:18:05Z cweiske $
 */

class Erfurt_Store_Default extends DBStore {
	public $SysOnt;
	public $_models;
	
	protected $store;
	
	protected $dbDriver;
	
	protected $SysOntURI = false;
	
	
	/**
	 * instance of ac-object
	 */
	protected $ac = null;
	
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
	function Erfurt_Store_Default($dbDriver, $host, $dbName, $user, $password, $SysOntURI = false, $tablePrefix = '') {
		DBStore::DBStore($dbDriver, $host, $dbName, $user, $password);
			
		// if 'tablePrefix' is set, attach SQL-rewrite function to store
		if(!empty($tablePrefix))
			$this->dbConn->fnExecute='pwlRewriteSQL';
		
		# register for init
		$this->dbDriver = $dbDriver;
		$this->SysOntURI = $SysOntURI;
	}
	
	/**
	 * init function
	 * 
	 * separate from constructor for exeption handling
	 */
	public function init() {
		# TODO: ERRORCODE
		if (!$this->isSetup($this->dbDriver)) 
			throw new Erfurt_Exception('Database Setup: Checking for tables ... no tables found.', 1);
			
		#if($SysOntURI)
		#	$this->SysOnt = $this->getModel($this->SysOntURI);
	}
	
	/**
	 * Create common tables for store
	 */
	function createTables() {
		$this->_createTables_MySql();
	}
	
	/**
	 * returns a list of available and permitted models
	 *   
	 */
	function listModels($returnAsArray = false) {
		$models=array();
		if($ms=parent::listModels()) {
			if($returnAsArray) {
				foreach($ms as $model) {
					if($this->aclCheck('View',$model['modelURI'])) {
						$models[] = $model;
					}
				}
				return $models;
			}
			foreach($ms as $model)
				if($this->aclCheck('View',$model['modelURI']))
					$models[$model['modelURI']]=$this->getModel($model['modelURI']);
		} else
			return $ms;
			
		return $models;
	}
	
	
	/**
	 * returns instance of an model-object
	 */
	function getModel($modelURI, $importedURIs=array(), $useACL = true) {
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
				$m=new OWLModel($this,$modelURI);
				foreach($m->listImports() as $import) if(is_a($import,'resource')) {
					if(!in_array(rtrim($import->getURI(),'#/'),$importedURIs) && $imp=$this->getModel($import->getURI(),$importedURIs, $useACL))
						$m->importsIds = array_merge($m->importsIds, array($imp->modelID => $imp->modelID), !empty($imp->importsIds) ? $imp->importsIds : array());
					$importedURIs[rtrim($import->getURI(),'#/')]=rtrim($import->getURI(),'#/');
				}
				if($m->importsIds)
					$m->importsSQL=' OR modelID='.join(' OR modelID=',$m->importsIds);
			}
			
			# look for edit possibility
			if ($useACL and $this->checkAc()) {
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
	function getNewModel($modelURI,$baseURI='',$type='RDFS', $useACL = true) {
		if($this->modelExists($modelURI, $useACL))
			return false;
		$mt=parent::getNewModel($modelURI,$baseURI);
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
	function loadModel($modelURI,$file=NULL,$loadImports=false,$stream=false,$filetype=NULL) {
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
	function deleteModel($modelURI) {
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
	function modelExists($modelURI, $useACL = true) {
		$args=func_get_args();
		$c=cache('modelExists',$args);
		if($c!==NULL)
			return $c;
		
		$modelExists = false; 
		if ($modelExists = parent::modelExists($modelURI)) {
			if (is_object($this->ac) and method_exists($this->ac, 'isModelAllowed'))
				if ($useACL and !$this->ac->isModelAllowed('view', $modelURI))
					$modelExists = false;
		}
		return cache('modelExists', $args, $modelExists);
	}
	
	/**
	 * Check if the DbModel with the given modelURI is already stored in the database
	 *
	 * @param   string   View || Edit || ??
	 * @param   mixed		Model-Object || URI-String
	 * @param   string 	Property
	 * @return  boolean
	 * @access	public
	 */
	function aclCheck($accessType,$model='',$property='',$class='',$instance='') {
		
		if(is_a($model,'Model'))
			$model = $model->modelURI;
		
		# ow user
		if ($this->checkAc()) {
			if ($this->ac->isModelAllowed('view', $model)) {
				return true;
			} else {
				return false;
			}  
		
		# OLD POWL STUFF => TODO: remove old powl ac
		} elseif($_SESSION['PWL']['user']=='Admin' || Zend_Registry::get('config')->deactivateLogin)
		# powl-admin and mode without login can use all models
			return true;
		
			if($_SESSION['PWL']['user']=='Admin' || Zend_Registry::get('config')->deactivateLogin)
		# powl-admin and mode without login can use all models
			return true;
			
		# check active user
		if(!$user = $this->SysOnt->getInstance($_SESSION['PWL']['user']))
			return false;
		if(!$model)
			return in_array($accessType,$user->listPropertyValuesPlain('userPrivileges'))?true:false;
		else if($accessType=='View')
			return in_array($model,$user->listPropertyValuesPlain('userModelsView'))||in_array($model,$user->listPropertyValuesPlain('userModelsEdit'))?true:false;
		else if($accessType=='Edit')
			return in_array($model,$user->listPropertyValuesPlain('userModelsEdit'))?true:false;
		else
			return $this->aclCompute($_SESSION['PWL']['user'],$accessType,$model,$property,$class,$instance);
	}
	function aclCompute($user,$accessType,$model,$property='',$class='',$instance='') {
		if(is_a($model,'Model'))
			$model=$model->modelURI;
		else if(is_a($model,'RDFSProperty')) {
			$property=$model;
			$model=$property->model->modelURI;
		} else if(is_a($model,'RDFSClass')) {
			$class=$model;
			$model=$class->model->modelURI;
		} else if(is_a($model,'RDFSInstance')) {
			$instance=$model;
			$model=$instance->model->modelURI;
		}
		if(!$this->SysOnt || !$acl=$this->SysOnt->getClass('ACL'))
			return true;

		$ret=true;
		// starting with true or false
		if($rule=$this->aclGet('',''))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// accessType
		if($rule=$this->aclGet('',$accessType))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// user, accessType
		if($rule=$this->aclGet($user,$accessType))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// model
		if($rule=$this->aclGet($user,$accessType,$model))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// property
		if($property && $rule=$this->aclGet($user,$accessType,$model,$property))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// class
		if($class && $rule=$this->aclGet($user,$accessType,$model,'',$class))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// instance
		if($instance && $rule=$this->aclGet($user,$accessType,$model,'','',$instance))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// property, class
		if($property && $class && $rule=$this->aclGet($user,$accessType,$model,$property,$class))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		// property, class, instance
		if($property && $class && $instance && $rule=$this->aclGet($user,$accessType,$model,$property,$class,$instance))
			$ret=$rule->getPropertyValuePlain('aclAllowDeny')=='Deny'?false:true;
		return $ret;
	}
	function aclGet($user,$accessType,$model='',$property='',$class='',$instance='') {
		$acl=$this->SysOnt->getClass('ACL');
		$ta=array(
			$this->SysOnt->modelURI.'aclModel'=>$model,
			$this->SysOnt->modelURI.'aclProperty'=>$property,
			$this->SysOnt->modelURI.'aclClass'=>$class,
			$this->SysOnt->modelURI.'aclInstance'=>$instance,
			$this->SysOnt->modelURI.'aclAccessType'=>$accessType?$this->SysOnt->modelURI.$accessType:'',
			$this->SysOnt->modelURI.'aclUser'=>$user?$this->SysOnt->modelURI.$user:'');
#print_r($ta);
		if($rules=$acl->findInstancesRecursive($ta)) {
#print_r($rules);
			return array_shift($rules);
		}
		else
			false;
	}

	/**
	 * This method checks whether a database with the fiven name exists.
	 *
	 * @param string $dbType type of the database (e.g. MySQL)
	 * @param string $dbName name of the database
	 * @return boolean Returns true in case the database exists, false else.
	 */
	function isDatabaseCreated($dbType="MySQL", $dbName) {
		switch (strtolower($dbType)) {
			case "mysql":
				$db =& $this->dbConn->execute("USE `".$dbName."`");
				if (!$db) return false;
				else return true;
		}
	}
	function isSetup() {
		if(Zend_Registry::get('config')->database->backend == 'powl')
			return true;
		else
			return parent::isSetup();
	}
	
	/**
	 * set the ac-object instance
	 * 
	 * @param object ac-object
	 */
	public function setAc($acObj = null) {
		$this->ac = $acObj;
	}
	
/**
	 * check the ac-object instance
	 * 
	 * @return boolean object is set
	 */
	public function checkAc() {
		return ($this->ac === null) ? false : true;
	}
}
?>
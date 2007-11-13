<?php
/*
 * Erfurt/Store/Abstract.php
 * Encoding: UTF-8
 *
 * Copyright (c) 2006 	Sören Auer <soeren@auer.cx>
 *                    	Philipp Frischmuth <philipp@frischmuth24.de>
 * 						Stefan Berger <berger@intersolut.de>
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
 * Erfurt_Store_Abstract
 *
 * @package rdfsapi
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2006
 * @version $Id$
 */
abstract class Erfurt_Store_Abstract extends DBStore implements Erfurt_Store_MainInterface {
		
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
	 * init function
	 * 
	 * separate from constructor for exeption handling
	 */
	public function init() {
//TODO: ERRORCODE
		if (!$this->isSetup()) {
			throw new Erfurt_Exception('Database Setup: Checking for tables ... no tables found.', 1);
		} 
	}

	public function countAvailableModels() {
		
		return count($this->listModels(true));
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
	public function aclCheck($accessType,$model='',$property='',$class='',$instance='') {
		
		if($model instanceof Model)
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
	
	public function aclCompute($user,$accessType,$model,$property='',$class='',$instance='') {
		if($model instanceof Model)
			$model=$model->modelURI;
		else if($model instanceof RDFSProperty) {
			$property=$model;
			$model=$property->model->modelURI;
		} else if($model instanceof RDFSClass) {
			$class=$model;
			$model=$class->model->modelURI;
		} else if($model instanceof RDFSInstance) {
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
	
	public function aclGet($user,$accessType,$model='',$property='',$class='',$instance='') {
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
	 * set the ac-object instance
	 * 
	 * @param object ac-object
	 */
	public function setAc($acObj = null) {
		$this->ac = $acObj;
	}
	
	/**
	 * get the ac-object instance
	 */
	public function getAc() {
		return $this->ac;
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

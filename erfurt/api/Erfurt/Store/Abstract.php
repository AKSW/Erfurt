<?php
/**
 * This class implements all methods, that are not backend-specific. A backend-specific store can extend this class.
 *
 * @package store
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2006-2007
 * @version $Id$
 */
abstract class Erfurt_Store_Abstract extends DBStore implements Erfurt_Store_MainInterface {
	
	/**
	 * @deprecated do not use this member directly, for it won't be public forever...
	 */
	public $SysOnt;
	
	/**
	 * @deprecated do not use this member directly, for it won't be public forever...
	 */
	public $_models;
	
	/**
	 * @var 
	 */ 
	protected $store;
	
	/**
	 * @var 
	 */
	protected $dbDriver;
	
	/**
	 * @var string The uri of the system ontology.
	 */
	protected $SysOntURI = false;
	
	/**
	 * @var Erfurt_Ac_Default/Erfurt_Ac_Statements_Abstract instance of ac-object
	 */
	protected $ac = null;
	
	
	/**
	 *  @see Erfurt_Store_MainInterface
	 */
	public function aclCheck($accessType,$model='',$property='',$class='',$instance='') {
		
		if ($model instanceof Model) {
			$model = $model->getModelURI();
		}
			
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
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function aclCompute($user,$accessType,$model,$property='',$class='',$instance='') {
		if($model instanceof Model)
			$model=$model->modelURI;
		else if($model instanceof Erfurt_Rdfs_Property) {
			$property=$model;
			$model=$property->model->modelURI;
		} else if($model instanceof RDFSClass) {
			$class=$model;
			$model=$class->model->modelURI;
		} else if($model instanceof Erfurt_Rdfs_Instance) {
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
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function aclGet($user,$accessType,$model='',$property='',$class='',$instance='') {
		
		$acl = $this->SysOnt->getClass('ACL');
		
		$ta = array(
			$this->SysOnt->modelURI.'aclModel' 		=> $model,
			$this->SysOnt->modelURI.'aclProperty'	=> $property,
			$this->SysOnt->modelURI.'aclClass'		=> $class,
			$this->SysOnt->modelURI.'aclInstance'	=> $instance,
			$this->SysOnt->modelURI.'aclAccessType'	=> $accessType ? $this->SysOnt->modelURI.$accessType : '',
			$this->SysOnt->modelURI.'aclUser'		=> $user ? $this->SysOnt->modelURI.$user : ''
		);

		if ($rules=$acl->findInstancesRecursive($ta)) {
			return array_shift($rules);
		} else {
			return false;
		}	
	}
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function checkAc() {
		
		return ($this->ac === null) ? false : true;
	}
	
	/**
	 * @see Erfurt_Store_CountableInterface
	 */
	public function countAvailableModels() {

		return count($this->listModels(true));
	}
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function getAc() {
		return $this->ac;
	}
	
	/**
	 * @see Erfurt_Store_MainInterface
	 */
	public function setAc($acObj = null) {
		
		$this->ac = $acObj;
	}
}
?>

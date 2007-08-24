<?php
/**
 * RDFSmodel
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: search.php 549 2006-03-06 02:19:04Z soerenauer $
 * @access public
 **/
abstract class Erfurt_Rdfs_InstanceSearch_Abstract {
	
	var $model;
	var $store;
	var $searchString;
	var $classes;
	var $properties;
	
	public function __construct(&$model,$searchString,$classes=array(),$properties=array()) {
		
		$this->model=&$model;
		$this->store = $model->getStore();
		$this->allModels=$model?false:true;
		$this->searchString=$searchString;
		$this->classes=$classes;
		foreach($this->classes as $class) {
			$cl=$this->model->classF($class);
			$this->classes=array_merge($this->classes,$cl->listSubClassesRecursive());
		}
		$this->properties=$properties;
	}
	
	abstract public function listClasses();
	abstract public function listProperties();
	abstract public function search($start = 0, $count = 10, $erg = 0);
	abstract public function searchInstance($instance);
}
?>

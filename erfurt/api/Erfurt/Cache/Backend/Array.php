<?php
/**
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache_Backend_Array {

	public $cacheArray;

	public function __construct() {
		
		$this->cacheArray = array();
	}
	
	public function load(DbModel $model, $function, Array $args, $resource) {
		
		$modelID = $model->getModelID();
		$uid = $this->getUID($function, $args, $resource);
		
		if (isset($this->cacheArray[$modelID][$uid])) {
			return $this->cacheArray[$modelID][$uid];
		} else {
			return false;
		}
	}
	
	public function save(DbModel $model, $function, Array $args, $resource, $value, Array $triggers) {
		
		$modelID = $model->getModelID();
		$uid = $this->getUID($function, $args, $resource);
		
		$this->cacheArray[$modelID][$uid] = $value;
	}
	
	public function expire(DbModel $model, Statement $stm) {
		
		$modelID = $model->getModelID();
		
		// whole cache for given model is cleared...
		unset($this->cacheArray[$modelID]);
	}
	
	public function expireFunction(DbModel $model, $function) {
		
		$modelID = $model->getModelID();
		
		// whole cache for given model is cleared...
		unset($this->cacheArray[$modelID]);
	}
	
	protected function getUID($function, Array $args, $resource) {
		
		if ($resource !== null) {
			$uid = $resource->getURI();
		} else {
			$uid = '';
		}
		
		$uid .= $function . serialize($args);
		$uid = md5($uid);
		
		return $uid;
	}
}
?>

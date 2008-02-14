<?php
/**
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache_Backend_Array implements Erfurt_Cache {

	protected $cacheArray;

	public function __construct() {
		
		$this->cacheArray = array();
	}
	
	public function load(DbModel $model, $function, $args, $resource) {
		
		$modelID = $model->getModelID();
		$uid = $this->_getUID($function, $args, $resource);
		
		if (isset($this->cacheArray[$modelID][$uid])) {
			return $this->cacheArray[$modelID][$uid];
		} else {
			return false;
		}
	}
	
	public function save(DbModel $model, $function, $args, $resource, $value, $triggers) {
		
		$modelID = $model->getModelID();
		$uid = $this->_getUID($function, $args, $resource);
		
		$this->cacheArray[$modelID][$uid] = $value;
	}
	
	public function expire(DbModel $model, Statement $stm = null) {
		
		$modelID = $model->getModelID();
		
		// whole cache for given model is cleared...
		unset($this->cacheArray[$modelID]);
	}
	
	public function emptyCache(DbModel $model) {
		
		$this->expire($model);
	}
	
	public function expireFunction(DbModel $model, $function) {
		
		$modelID = $model->getModelID();
		
		// whole cache for given model is cleared...
		unset($this->cacheArray[$modelID]);
	}
	
	protected function _getUID($function, $args, $resource) {
		
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

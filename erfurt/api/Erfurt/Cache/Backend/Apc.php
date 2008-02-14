<?php
/**
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache_Backend_Apc implements Erfurt_Cache {

	public function __construct() {
	
		if (!extension_loaded('apc')) {
// TODO exception code
			throw new Erfurt_Exception();
		}
	}
	
	public function load(DbModel $model, $function, Array $args, $resource) {
		
		$modelID = $model->getModelID();
		$uid = $this->getUID($modelID, $function, $args, $resource);
		
		$result = apc_fetch($uid);
		
		if (is_array($result)) {
			return unserialize($result[0]);
		} else {
			return false;
		}
	}
	
	public function save(DbModel $model, $function, Array $args, $resource, $value, Array $triggers) {
		
		$modelID = $model->getModelID();
		$uid = $this->getUID($modelID, $function, $args, $resource);
		
		apc_store($uid, array(serialize($value)));
	}
	
	public function expire(DbModel $model, Statement $stm) {
		
		apc_clear_cache('user');
	}
	
	public function emptyCache(DbModel $model) {
		
		$this->expire($model);
	}
	
	public function expireFunction(DbModel $model, $function) {
		
		apc_clear_cache('user');
	}
	
	protected function getUID($modelID, $function, Array $args, $resource) {
		
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

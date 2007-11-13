<?php
class Erfurt_Cache {

	public $firstLevelCache;
	protected $secondLevelCache;
	
	public function __construct(Erfurt_Store_Default $store) {
		
		if (extension_loaded('apc')) {
			$this->firstLevelCache = new Erfurt_Cache_Backend_Apc();
		} else {
			
			$this->firstLevelCache = new Erfurt_Cache_Backend_Array();
		}
		
		$this->secondLevelCache = new Erfurt_Cache_Backend_Database($store);
	}

	public function load(DbModel $model, $function, Array $args = array(), $resource = null, $firstLevelOnly = false) {
		
		// cache disabled?
		if (!Zend_Registry::get('config')->cache->enable) {
			return false;
		}
		
		$value = $this->firstLevelCache->load($model, $function, $args, $resource);
		if ($value) {
			#echo "LEVEL1<br />";
			return $value;
		} else if (!$firstLevelOnly) {
			$value = $this->secondLevelCache->load($model, $function, $args, $resource);
			if ($value) {
				#echo "LEVEL2<br />";
				$this->firstLevelCache->save($model, $function, $args, $resource, $value, null);
				return $value;
			}
		} 
		
		#echo "UNCACHED";
		return false;
	}
	
	public function save(DbModel $model, $function, Array $args = array(), $resource = null, $value, Array $triggers = array(), $firstLevelOnly = false) {
	
		// cache disabled?
		if (!Zend_Registry::get('config')->cache->enable) {
			return;
		}
		
		$this->firstLevelCache->save($model, $function, $args, $resource, $value, $triggers);
		
		if (!$firstLevelOnly) {
			$this->secondLevelCache->save($model, $function, $args, $resource, $value, $triggers);
		}
	}
	
	public function expire(DbModel $model, Statement $stm = null) {
		
		// cache disabled?
		if (!Zend_Registry::get('config')->cache->enable) {
			return;
		}
		
		$this->firstLevelCache->expire($model, $stm);
		$this->secondLevelCache->expire($model, $stm);
	} 
	
	public function expireFunction(DbModel $model, $function) {
		
		// cache disabled?
		if (!Zend_Registry::get('config')->cache->enable) {
			return;
		}
		
		$this->firstLevelCache->expireFunction($model, $function);
		$this->secondLevelCache->expireFunction($model, $function);
	}
}
?>

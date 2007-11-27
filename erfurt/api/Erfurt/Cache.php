<?php
/**
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache {

	public $firstLevelCache;
	protected $secondLevelCache;
	
	public function __construct(Erfurt_Store_Abstract $store) {
		
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
	
	public function isCached(DbModel $model, $function, Array $args = array(), $resource = null, $firstLevelOnly = false) {
		
	}
	
	/**
	 * This method is for debugging... it returns the current cache state. That means it returns an integer number
	 * representing what the load method would return. It does not change the current status of caching, i.e. uncached
	 * values stay uncached. 
	 *
	 * @return int Returns 0 iff uncached, 1 iff level1-cached, 2 iff level2-cached, 3 iff level1-and-level2-cached
	 */
	public function getCacheState(DbModel $model, $function, Array $args = array(), $resource = null, $firstLevelOnly = false) {
		
	}
}
?>

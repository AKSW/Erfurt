<?php
/**
 * This is the frontend class for the caches. Currently there is a first-level-cache (array) and a second-level-cache
 * (database)... If the APC extension is installed an (experimental) APC-Backend is used for caching (both first and 
 * second level, for this should be faster)
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache_Frontend {

	protected $firstLevelCache;
	protected $secondLevelCache;
	
	protected $_isEnabled;
		
	public function __construct(Erfurt_Store_Abstract $store) {
		
		if (extension_loaded('apc')) {
			$this->firstLevelCache = new Erfurt_Cache_Backend_Apc();
			$this->secondLevelCache = new Erfurt_Cache_Backend_Apc();
		} else {
			
			$this->firstLevelCache = new Erfurt_Cache_Backend_Array();
			$this->secondLevelCache = new Erfurt_Cache_Backend_Database($store);
		}
		
		// cache disabled?
		if (Zend_Registry::get('config')->cache->enable) {
			$this->_isEnabled = true;
		} else {
			$this->_isEnabled = false;
		}
	}
	
	public function loadFirstLevel(DbModel $model, $function, $args = array(), $resource = null) {
		
		if (!$this->_isEnabled) {
			return false;
		}
		
		return $this->firstLevelCache->load($model, $function, $args, $resource);
	}
	
	public function loadSecondLevel(DbModel $model, $function, $args = array(), $resource = null) {
		
		if (!$this->_isEnabled) {
			return false;
		}
		
		return $this->secondLevelCache->load($model, $function, $args, $resource);
	}
	
	public function saveFirstLevel(DbModel $model, $function, $args = array(), $resource = null, $value, 
			$triggers = array()) {
			
		if (!$this->_isEnabled) {
			return $value;
		}
		
		return $this->firstLevelCache->save($model, $function, $args, $resource, $value, $triggers);
	}
	
	public function saveSecondLevel(DbModel $model, $function, $args = array(), $resource = null, $value, 
			$triggers = array()) {
	
			if (!$this->_isEnabled) {
				return $value;
			}

		return $this->secondLevelCache->save($model, $function, $args, $resource, $value, $triggers);
	}
	
	public function expireFirstLevel(DbModel $model, Statement $stm = null) {
		
		if (!$this->_isEnabled) {
			return;
		}
		
		$this->firstLevelCache->expire($model, $stm);
	}
	
	public function expireSecondLevel(DbModel $model, Statement $stm = null) {
		
		if (!$this->_isEnabled) {
			return;
		}
		
		$this->secondLevelCache->expire($model, $stm);
	}
	
	public function emptyFirstLevel(DbModel $model) {
		
		if (!$this->_isEnabled) {
			return;
		}
		
		$this->firstLevelCache->empty($model);
	}
	
	public function emptySecondLevel(DbModel $model) {
		
		if (!$this->_isEnabled) {
			return;
		}
		
		$this->secondLevelCache->emptyCache($model);
	}
}
?>

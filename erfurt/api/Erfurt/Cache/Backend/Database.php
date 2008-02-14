<?php
/**
 * 
 * @package cache
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 */
class Erfurt_Cache_Backend_Database implements Erfurt_Cache {

	protected $store;

	public function __construct(Erfurt_Store_Abstract $store) {
	
		$this->store = $store;
	}
	
	public function load(DbModel $model, $function, $args, $resource) {
				
		if ($resource instanceof Resource) {
			$resource = $resource->getURI();
		} else if ($resource === null) {
			$resource = '';
		}
		
		$sql = 'SELECT value FROM cache 
				WHERE model = ' . $model->getModelID() . ' AND function = "' . $function . '" 
				AND args = "' . $this->_getUID($args) . '" AND ef_resource = "' . $resource . '"';
				
		$value = $this->store->dbConn->getOne($sql);
		
		if ($value) {
			return unserialize($value);
		} else {
			return false;
		}	
	}
	
	public function save(DbModel $model, $function, $args, $resource, $value, $triggers) {
		if ($resource instanceof Resource) {
			$resource = $resource->getURI();
		} else if ($resource === null) {
			$resource = '';
		}
				
		foreach ($triggers as $trigger) {
			if ($trigger instanceof Resource) {
				$trigger = $trigger->getURI();
			}
		}
		
		$value = $this->store->dbConn->qstr(serialize($value));
		
		$sql = 'REPLACE cache SET value = ' . $value . ', 
				function = "' . $function . '", 
				args = "' . $this->_getUID($args) . '",
				model = ' . $model->getModelID() . ', 
				ef_resource = "' . $resource .'", 
				trigger1 = "' . serialize($triggers) .'"'; 
		
		$this->store->dbConn->execute($sql);
		#echo $this->store->dbConn->errorMsg();
	}
	
	public function expire(DbModel $model, Statement $stm = null) {
		
		if ($statement === null) {
			$sql = 'DELETE FROM cache WHERE model = ' . $model->getModelID();
		} else {
			$triggers = '"' . $stm->getSubject()->getURI() . '", "' . $stm->getPredicate()->getURI() . '", ' .
						$stm->getObject()->getURI() . '"';
						
			$sql = 'DELETE FROM cache WHERE model = ' . $model->getModelID() . ' AND ((trigger1 = "a:0:{}") OR (trigger1 LIKE "%' . $stm->getLabelSubject() . '%") OR (trigger1 LIKE "%' . $stm->getLabelPredicate() . '%") OR (trigger1 LIKE "%' . $stm->getLabelObject() . '%"))';
		}
		
		$this->store->dbConn->execute($sql);
	}
	
	public function emptyCache(DbModel $model) {
		
		$this->expire($model);
	}
	
	public function expireFunction(DbModel $model, $function) {
		
		$sql = 'DELETE FROM cache WHERE model = ' . $model->getModelID() . ' AND function = "' . $function . '"';
		
		$this->store->dbConn->execute($sql);
	}
	
	protected function _getUID($args) {
		
		return crc32(serialize($args));
	}
}
?>

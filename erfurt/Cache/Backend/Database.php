<?php
class Erfurt_Cache_Backend_Database {

	protected $store;

	public function __construct(Erfurt_Store_Default $store) {
	
		$this->store = $store;
	}
	
	public function load(DbModel $model, $function, Array $args, $resource) {
				
		if ($resource instanceof Resource) {
			$resource = $resource->getURI();
		} else if ($resource === null) {
			$resource = '';
		}
		
		$sql = 'SELECT value FROM cache 
				WHERE model = ' . $model->getModelID() . ' AND function = "' . $function . '" 
				AND args = "' . $this->getUID($args) . '" AND resource = "' . $resource . '"';
				
		$value = $this->store->dbConn->getOne($sql);
		
		if ($value) {
			return unserialize($value);
		} else {
			return false;
		}	
	}
	
	public function save(DbModel $model, $function, Array $args, $resource, $value, Array $triggers) {
		
		if ($resource instanceof Resource) {
			$resource = $resource->getURI();
		} else if ($resource === null) {
			$resource = '';
		}
		
		$tr = array();
		foreach ($triggers as $trigger) {
			if ($trigger !== null) {
				if (is_string($trigger)) {
					if ($trigger === 'ALL') {
						$tr[] = 'ALL';
					} else {
						$tr[] = $model->_dbId($trigger);
					}
				} else {
					$tr[] = ($trigger instanceof Resource) ? $trigger->getURI() : '';
				}
			}			
		}
		
		$value = $this->store->dbConn->qstr(serialize($value));
		
		$sql = 'REPLACE cache SET value = ' . $value . ', 
				function = "' . $function . '", 
				args = "' . $this->getUID($args) . '",
				model = ' . $model->getModelID() . ', 
				resource = "' . $resource .'", 
				trigger1 = "' . $tr[0].'", 
				trigger2 = "' . $tr[1].'", 
				trigger3 = "' . $tr[2].'"'; 
		
		$this->store->dbConn->execute($sql);
	}
	
	public function expire(DbModel $model, Statement $stm) {
		
		if ($statement === null) {
			$triggers = '"ALL"';
		} else {
			$triggers = '"ALL", "' . $stm->getSubject()->getURI() . '", "' . $stm->getPredicate()->getURI() . '", ' .
						$stm->getObject()->getURI() . '"';
		}
		
		$sql = 'DELETE FROM cache WHERE model = ' . $model->getModelID() . ' AND (trigger1 IN (' . $triggers .') 
				OR trigger2 IN (' . $triggers . ') OR trigger3 IN (' . $triggers . '))';
		
		$this->store->dbConn->execute($sql);
	}
	
	public function expireFunction(DbModel $model, $function) {
		
		$sql = 'DELETE FROM cache WHERE model = ' . $model->getModelID() . ' AND function = "' . $function . '"';
		
		$this->store->dbConn->execute($sql);
	}
	
	protected function getUID(Array $args) {
		
		return crc32(serialize($args));
	}
}
?>

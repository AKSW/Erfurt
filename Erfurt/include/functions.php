<?php
function cacheGetUidFromArgs(&$args) {
	return crc32((serialize($args).$GLOBALS['RAP']['conf']['database']['tblStatements']));
	foreach($args as $arg)
		if(is_object($arg)) {
			if(method_exists($arg,'toString'))
				$uid.=$arg->toString();
			else
				$uid.=serialize($arg);
		} else if(is_array($arg))
			$uid.=serialize($arg);
		else if(is_null($arg))
			$uid.='NULL';
		else $uid.=$arg;
	return crc32($uid);
}
function cache($fn, $args = array(), $value = null) {
	
	if (!Zend_Registry::get('config')->cache->enable) {
		return $value;
	}
		
	if (Zend_Registry::isRegistered('cache')) {
		$cache = Zend_Registry::get('cache');
	} else { 
		Zend_Registry::set('cache', array());
		$cache = Zend_Registry::get('cache');
	}

	$uid = cacheGetUidFromArgs($args);
	if (func_num_args() == 3) {
		$cache[$fn][$uid] = $value;
	} else {
		$value = isset($cache[$fn][$uid]) ? $cache[$fn][$uid] : null;
	}
		
	Zend_Registry::set('cache', $cache);
	return $value;
}
/**
 * CREATE TABLE `cache` (
 *   `id` int(11) NOT NULL auto_increment,
 *   `trigger1` varchar(255) NOT NULL default '',
 *   `trigger2` varchar(255) NOT NULL default '',
 *   `trigger3` varchar(255) NOT NULL default '',
 *   `function` varchar(255) NOT NULL default '',
 *   `args` varchar(255) NOT NULL default '',
 *   `model` int(11) NOT NULL default '0',
 *   `resource` varchar(255) NOT NULL default '',
 *   `value` longblob NOT NULL,
 *   PRIMARY KEY  (`id`),
 *   UNIQUE KEY `function` (`function`,`args`,`model`,`resource`)
 * )
 * 
 * @package cache
 * @deprecated wil be replaced by new Erfurt_Cache classes<strong></strong>
 */
Class stmCache {
	var $value=NULL;
	function stmCache($function='',$args=array(),$model='',$resource='') {
		$this->fn=$function;
		$this->args=cacheGetUidFromArgs($args);
		$this->model=$model;
		$this->resource=$resource;
		$this->get();
	}
	
	/**
	 * returns list of cached vars
	 *
	 * @return mixed value
	 */
	function get() {
		if(Zend_Registry::get('config')->cache->enable && ($ret = Zend_Registry::get('erfurt')->getStore()->dbConn->getOne("SELECT value FROM cache WHERE function='".$this->fn."' AND args='".$this->args."' AND model=".$this->model->modelID." AND ef_resource='".$this->resource."'"))) {
			//print_r(unserialize($ret));
			return unserialize($ret);
		}
			
		
		return null;
	}
	
	/**
	 * set cache value
	 *
	 * @param mixed $value
	 * @param array $triggers
	 */
	function set($value,$triggers = array()) {
		if(!is_array($triggers))
			$triggers = array($triggers);
		$this->value=$value;
		if(Zend_Registry::get('config')->cache->enable) {
			if(count($triggers)<=3) {
				foreach($triggers as $trigger)
					$tr[]=is_a($trigger, 'resource') ? $trigger->getURI() : $this->model->_dbId($trigger);
			}
			Zend_Registry::get('erfurt')->getStore()->dbConn->execute("REPLACE cache SET value=".Zend_Registry::get('erfurt')->getStore()->dbConn->qstr(serialize($value)).",function='{$this->fn}',args='{$this->args}',model='{$this->model->modelID}',ef_resource='{$this->resource}',trigger1='{$tr[0]}',trigger2='{$tr[1]}',trigger3='{$tr[2]}'");
		}
	}
	
	
	function expire($stm) {
		
		if (Zend_Registry::get('config')->cache->enable) {
			foreach (($stm instanceof Statement) ? array($stm->subj, $stm->pred, $stm->obj) : func_get_args() as $arg) {
				if ($arg instanceof Erfurt_Rdfs_Resource) {
					$sql = "DELETE FROM cache WHERE model={$arg->getModel()->getModelID()} AND
						(trigger1='".$arg->getURI()."' OR trigger1='' OR trigger2='".$arg->getURI()."' OR trigger3='".$arg->getURI()."')";
					Zend_Registry::get('erfurt')->getStore()->dbConn->execute($sql);
				}
			}
		}			
	}
	
	function emptyCache() {
		
		if (Zend_Registry::get('config')->cache->enable) {
			Zend_Registry::get('erfurt')->getStore()->dbConn->execute("DELETE FROM cache WHERE model={$this->model->modelID}");
		}
		
	}
}
?>
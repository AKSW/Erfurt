<?php
/**
  * class providing OntoWiki custom view management.
  *
  * @package ac
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id$
  */
class Erfurt_Ac_Statements_Views_Rap  extends Erfurt_Ac_Statements_Views_Abstract  {
	
	/**
	 * db connection string
	 * 
	 * @var object
	 */
	private $db = null;
	
	
	/**
	 * constructor
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->db = Zend_Registry::get('erfurt')->getStore()->dbConn;
	}
	
	/**
	 * create view
	 * 
	 * @return array list of views
	 */
	public function getViews() {
		$sql = "SELECT TABLE_NAME
							FROM information_schema.views
							WHERE TABLE_SCHEMA = '".$this->db->database."'";
		$views = $this->db->getAll($sql);
		$ret = array();
		if ($views) {
			foreach($views as $row) {
				$ret[] = $row[0];
			}
		}
		return $ret;
	}
	
	/**
	 * create view
	 * 
	 * @return bool result
	 */
	public function createView($name, $from, $where, $add, $merge = true, $type = 'view') {
		$alg = '';
		if ($merge) {
			$alg = 'ALGORITHM=MERGE';
		} else {
			$alg = 'ALGORITHM=TEMPTABLE';
		}
		$sql = 'CREATE '.$alg.' VIEW '.$name.' '."\n".'AS SELECT t0.* '.$from.' '."\n".' WHERE 1 '.$where.' '."\n".$add;
		#printr($sql);exit;
		$res = $this->db->Execute($sql);
		return $res;
	}
	
	/**
	 * drop a special views
	 * 
	 * @return bool result
	 */
	public function dropView($viewName) {
		$views = $this->getViews();
		$sql = "DROP VIEW IF EXISTS '".$viewName."'";
		$res = $this->db->Execute($sql);
		return $res;
	}

	/**
	 * drops all available views
	 * 
	 * @return bool result
	 */
	public function dropViews() {
		$views = $this->getViews();
		$sql = "DROP VIEW IF EXISTS ".implode(", ", $views);
		$res = $this->db->Execute($sql);
		return $res;
	}
	
	
	
}

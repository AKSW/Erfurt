<?php
/**
  * class providing OntoWiki custom view management.
  *
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id: $
  */
class Erfurt_Ac_Statements_Views_Rap  extends Erfurt_Ac_Statements_Views_Abstract  {
	
	private $db = null;
	
	public function __construct() {
		$this->db = Zend_Registry::get('erfurt')->getStore()->dbConn;
	}
	
	public function getViews() {
		$sql = 'SELECT TABLE_NAME
							FROM information_schema.views';
		$views = $this->db->getAll($sql);
		$ret = array();
		if ($views) {
			foreach($views as $row) {
				$ret[] = $row[0];
			}
		}
		return $ret;
	}
	
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
	
	public function dropView($viewName) {
		
	}

	public function dropViews() {
		$views = $this->getViews();
		$sql = "DROP VIEW IF EXISTS ".implode(", ", $views);
		$res = $this->db->Execute($sql);
		return $res;
	}
	
	
	
}

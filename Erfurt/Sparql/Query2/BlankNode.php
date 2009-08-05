<?php

require_once "Query2/Var.php";

/**
 * Erfurt_Sparql Query - BlankNode.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_BlankNode extends Erfurt_Sparql_Query2_Var{ //TODO 1. may not appear in two different graphs. 2. an anon bn should only be used once (fix in ...GraphPattern)
	protected $name = "";
	
	public function __construct($nname){
		if(!is_bool($nname) && is_string($nname) && !empty($nname))
			$this->name = $nname;
	}
	
	public function getSparql(){
		return $this->isAnon() ? "[]" : "_:".$this->name;
	}
	public function getName(){
		return $this->name;
	}
	public function isAnon(){
		return empty($this->name);
	}
}
?>

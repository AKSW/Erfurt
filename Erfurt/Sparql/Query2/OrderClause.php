<?php
/**
 * Erfurt_Sparql Query - OrderClause.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_OrderClause
{
	public $direction = "ASC";
	public $vars = array();
	
	public function addVar(Erfurt_Sparql_Query2_Var $var){
		$this->vars[] = $var;
		return $this; //for chaining
	}
	
	public function getSparql(){
		$sparql = "ORDER ".$this->direction."(";
		for ($i = 0; $i < count($this->vars); $i++){
			$sparql .="?".$this->vars[$i]->getName();
			if($i < (count($this->vars)-1))
				$sparql .= ", ";
		}
		$sparql .= ")";
		return $sparql;
	}
	
	public function toggleDirection(){
		$this->direction= $this->direction=="ASC"?"DESC":"ASC";
		return $this; //for chaining
	}
	public function setAsc(){
		$this->direction = "ASC";
		return $this; //for chaining
	}
	public function setDesc(){
		$this->direction = "DESC";
		return $this; //for chaining
	}
	
	public function used(){
		return !empty($this->vars);
	}
}


?>

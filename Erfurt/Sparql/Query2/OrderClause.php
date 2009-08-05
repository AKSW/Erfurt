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
	}
	public function setAsc(){
		$this->direction = "ASC";
	}
	public function setDesc(){
		$this->direction = "DESC";
	}
	
	public function used(){
		return !empty($this->vars);
	}
}


?>

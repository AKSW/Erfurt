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
	public $exps = array();
	
	public function add(Erfurt_Sparql_Query2_Expression $exp){
		
		$order = "ASC";
		
		if(func_num_args()>1){
			$order = func_get_arg(1);
			if($order == "ASC" || $order == "DESC"){
				//ok
			} else {
				throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_OrderClause::add must be \"ASC\" or \"DESC\", ".$order." (instance of ".typeHelper($order).") given");
			}
		}
		$this->exps[] = array("exp"=>$exp, "dir"=>$order);
		return count($this->exps)-1;
	}
	
	public function getSparql(){
		$sparql = "ORDER BY";
		for ($i = 0; $i < count($this->exps); $i++){
			$sparql .=" ".$this->exps[$i]["dir"]."(".$this->exps[$i]["exp"]->getSparql().")";
			if($i < (count($this->exps)-1))
				$sparql .= ", ";
		}
		$sparql .= "";
		return $sparql;
	}
	
	public function toggleDirection($i){
		$this->exps[$i]["dir"] = $this->exps[$i]["dir"]=="ASC"?"DESC":"ASC";
		return $this; //for chaining
	}
	public function setAsc($i){
		$this->exps[$i]["dir"] = "ASC";
		return $this; //for chaining
	}
	public function setDesc($i){
		$this->exps[$i]["dir"] = "DESC";
		return $this; //for chaining
	}
	
	public function used(){
		return !empty($this->exps);
	}
}


?>

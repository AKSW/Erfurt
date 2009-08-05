<?php
//DEBUG
error_reporting(E_ALL);
 
require_once "Query2/Prefix.php";
require_once "Query2/OrderClause.php";
require_once "Query2/TriplesBlock.php";
require_once "Query2/Triple.php";
require_once "Query2/Var.php";
require_once "Query2/GroupGraphPattern.php";
require_once "Query2/GroupOrUnionGraphPattern.php";
require_once "Query2/OptionalGraphPattern.php";

/**
 * Erfurt Sparql Query
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2
{
	const typeSelect = "SELECT";
	const typeAsk = "ASK";
	const typeConstruct = "CONSTRUCT";
	const typeDescribe = "DESCRIBE";
	
	protected $type = Erfurt_Sparql_Query2::typeSelect;
	protected $limit = 0;
	protected $offset = 0;
	protected $distinctReducedMode = 0;
	protected $reduced = false;
	protected $order;
	protected $selectVars = array();
	protected $star = true;
	protected $pattern;
	protected $prefixes = array();
	protected $froms = array();
	protected $base;
	
	public function __construct(){
		$this->order = new Erfurt_Sparql_Query2_OrderClause();
	}
	
	public function getSparql(){
		$sparql = "";
		
		if($this->hasBase()){
			$sparql .= "BASE ".$this->base;
		}
		
		foreach($this->prefixes as $prefix)
			$sparql .= $prefix->getSparql()." \n";
		
		$sparql .= $this->type." ";
		
		if($this->isSelectType()){
			switch($this->distinctReducedMode){
				case 0:
				break;
				case 1:
				$sparql .= "DISTINCT ";
				break;
				case 2:
				$sparql .= "REDUCED ";
				break;
			}

			if(count($this->selectVars) != 0 && !$this->star){
				foreach($this->selectVars as $selectVar){
					$sparql .= $selectVar->getSparql()." ";
				}
			} else {
				$sparql .= "*";
			}
		
			$sparql .= " \n";
			
			foreach($this->froms as $from){
				$sparql .= "FROM ".$from->getSparql()." \n";
			}
		}
		$sparql .= "WHERE ".$this->pattern->getSparql(); //the "where"-keyword is optional - anyway: always used

		if($this->hasOrderBy()){
			$sparql .= $this->order->getSparql()." \n";
		}
		if($this->hasLimit()){
			$sparql .= "LIMIT ".$this->limit." \n";
		}
		
		if($this->hasOffset()){
			$sparql .= "OFFSET ".$this->offset." \n";
		}
		
		return $sparql;
	}
	
	public function setQueryType($type){
		switch($type){
			case Erfurt_Sparql_Query2::typeSelect:
			case Erfurt_Sparql_Query2::typeAsk:
			case Erfurt_Sparql_Query2::typeDescribe:
			case Erfurt_Sparql_Query2::typeConstruct:
				$this->type = $type;
			break;
			default:
				throw new RuntimeException("Erfurt_Sparql_Query2::setType : Unknown query type given: \"".$type."\"");
		}
	}
	
	public function isSelectType(){
		return $this->type == Erfurt_Sparql_Query2::typeSelect;
	}
	
	public function isAskType(){
		return $this->type == Erfurt_Sparql_Query2::typeAsk;
	}
	
	public function isDescribeType(){
		return $this->type == Erfurt_Sparql_Query2::typeDescribe;
	}
	
	public function isContructType(){
		return $this->type == Erfurt_Sparql_Query2::typeConstruct;
	}

	public function hasOffset(){
		return !empty($this->offset);
	}
	
	public function hasLimit(){
		return !empty($this->limit);
	}
	
	public function hasOrderBy(){
		return $this->order->used();
	}
	
	public function setPattern(Erfurt_Sparql_Query2_GroupGraphPattern $npattern){
		//TODO maybe add check here that the pattern doesnt contain two variables with same name
		$this->pattern = $npattern;
	}
	
	public function getPattern(){
		return $this->pattern;
	}
	
	public function setLimit($nlimit){
		$this->limit = $nlimit;
	}
	
	public function removeLimit(){
		$this->limit = 0;
	}
	
	public function getLimit(){
		return $this->limit;
	}
	
	public function setOffset($noffset){
		$this->offset = $noffset;
	}
	
	public function removeOffset(){
		$this->offset = 0;
	}
	
	public function getOffset(){
		return $this->offset;
	}
	
	public function setStar($bool){
		if($bool) $this->selectVars = array(); // delete projection vars if set to star mode - usefull?
		$this->star = $bool;
	}
	
	public function isStar(){
		return count($this->selectVars) == 0 || $this->star;
	}
	
	public function setDistinct($bool){
		if($bool) $this->distinctReducedMode = 1;
		else if($this->distinctReducedMode == 1) 
			$this->distinctReducedMode = 0;
	}
	
	public function isDistinct(){
		return $this->distinct;
	}
	
	public function setReduced($bool){
		if($bool) 
			$this->distinctReducedMode = 2;
		else if($this->distinctReducedMode == 2) 
			$this->distinctReducedMode = 0;
	}
	
	public function isReduced(){
		return $this->reduced;
	}
	
	public function setBase($base){
		$this->base = $base;
	}
	
	public function getBase($base){
		return $this->base;
	}
	
	public function hasBase(){
		return !empty($this->base);
	}
	
	public function addFrom(GraphClause $from){
		$this->froms[] = $from;
	}
	
	public function getFrom($i){
		return $this->froms[$i];
	}
	
	public function getFroms(){
		return $this->froms;
	}
	
	public function setFrom($i, GraphClause $from){
		if(!is_int($i)) throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2::setFrom must be an instance of int, instance of ".gettype($i)." given");
		$this->froms[$i] = $from;
	}
	
	public function hasFrom(){
		return !empty($this->froms);
	}
	
	public function addProjectionVar(Erfurt_Sparql_Query2_Var $var){
		if(in_array($var, $this->selectVars)){
			//already added
			return;
		}
		
		if(!in_array($var, $this->pattern->getVars())){
			throw new RuntimeException("Trying to add projection-var that is not used in pattern");
			return;
		}
		
		if(count($this->selectVars) == 0)
			$this->star = false; //if the first var is added: deactivate the star. maybe always?
		
		$this->selectVars[] = $var;
	}
	
	public function addPrefix(Erfurt_Sparql_Query2_Prefix $prefix){
		$this->prefixes[] = $prefix;
	}
	
	public function getProjectionVars(){
		return $this->pattern->getVars();
	}
	
	public function getOrder(){
		return $this->order;
	}
}
?>
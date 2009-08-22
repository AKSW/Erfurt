<?php
//DEBUG
error_reporting(E_ALL);

require_once "Query2/structural-Interfaces.php";
require_once "Query2/ObjectHelper.php";
require_once "Query2/Prefix.php";
require_once "Query2/OrderClause.php";
require_once "Query2/GraphClause.php";
require_once "Query2/ObjectList.php";
require_once "Query2/Triple.php";
require_once "Query2/TriplesSameSubject.php";
require_once "Query2/Constraint.php";
require_once "Query2/Var.php";
require_once "Query2/GroupGraphPattern.php";
require_once "Query2/GroupOrUnionGraphPattern.php";
require_once "Query2/OptionalGraphPattern.php";
require_once "Query2/ConstructTemplate.php";
require_once "Query2/IriRef.php";
require_once "Query2/RDFLiteral.php";
require_once "Query2/NumericLiteral.php";
require_once "Query2/Nil.php";
require_once "Query2/BooleanLiteral.php";
require_once "Query2/BlankNode.php";
require_once "Query2/Abstraction.php";
require_once "Query2/A.php";
require_once "Query2/Filter.php";

//TODO: is there a better way for getting the type/class?
function typeHelper($obj){
	$class=(string) get_class($obj);
	$type=(string) gettype($obj); 
	$disptype = empty($class)?$type:$class;
	return $disptype;
}

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
	
	protected $type;
	protected $limit = 0;
	protected $offset = 0;
	protected $distinctReducedMode = 0;
	protected $order;
	protected $selectVars = array();
	protected $star = true;
	protected $pattern;
	protected $prefixes = array();
	protected $froms = array();
	protected $base;
	protected $constructTemplate;
	
	public static $idCounter = 0;
	
	static function getNextID(){
		return self::$idCounter++;
	}
	
	public function __construct(){
		$this->order = new Erfurt_Sparql_Query2_OrderClause();
		$this->where = new Erfurt_Sparql_Query2_GroupGraphPattern;
		$type = self::typeSelect;
		if(func_num_args()>0){
			$type = func_get_arg(0);
		}
		$this->setQueryType($type);
	}
	
	public function __toString() 
    {    
        return $this->getSparql();
    }
    
	public function getSparql(){
		$sparql = "";
		
		if($this->hasBase()){
			$sparql .= "BASE ".$this->base->getSparql()." \n";
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
		}
		if($this->isSelectType() || $this->isDescribeType()){
			if(count($this->selectVars) != 0 && !$this->star){
				foreach($this->selectVars as $selectVar){
					$sparql .= $selectVar->getSparql()." ";
				}
			} else {
				if(!$this->isAskType())
					$sparql .= "*";
			}
		}
		$sparql .= " \n";
		
		if($this->isConstructType()){
			$sparql .= $this->constructTemplate->getSparql();
		}
		
		foreach($this->froms as $from){
			$sparql .= "FROM ".$from->getSparql()." \n";
		}
		
		if(!($this->isDescribeType() && count($this->where->getElements()) == 0))
			$sparql .= "WHERE ".$this->where->getSparql();
		
		if(!$this->isAskType()){
			if($this->hasOrderBy()){
				$sparql .= $this->order->getSparql()." \n";
			}
			if($this->hasLimit()){
				$sparql .= "LIMIT ".$this->limit." \n";
			}
			
			if($this->hasOffset()){
				$sparql .= "OFFSET ".$this->offset." \n";
			}
		}
		
		return $sparql;
	}
	
	public function setQueryType($type){
		//special configs for different types...
		switch($type){
			case Erfurt_Sparql_Query2::typeSelect:
			break;
			case Erfurt_Sparql_Query2::typeAsk:
				//ask has no solution modifyer - delete?
				//$this->setLimit(0);
				//$this->setOffset(0);
				//$this->order = new Erfurt_Sparql_Query2_OrderClause();
				//$this->distinctReducedMode = 0;
				//$this->selectVars = array();
			break;
			case Erfurt_Sparql_Query2::typeDescribe:
			break;
			case Erfurt_Sparql_Query2::typeConstruct:
				$this->constructTemplate = new Erfurt_Sparql_Query2_ConstructTemplate();
			break;
			default:
				throw new RuntimeException("Erfurt_Sparql_Query2::setQueryType : Unknown query type given: \"".$type."\"");
		}
		//save type
		$this->type = $type;
		return $this; //for chaining
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
	
	public function isConstructType(){
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
	
	public function setWhere(Erfurt_Sparql_Query2_GroupGraphPattern $npattern){
		//TODO maybe add check here that the pattern doesnt contain two variables with same name
		$this->where = $npattern;
		return $this; //for chaining
	}
	
	public function getWhere(){
		return $this->where;
	}
		
	public function setConstructTemplate(Erfurt_Sparql_Query2_ConstructTemplate $npattern){
		//TODO maybe add check here that the pattern doesnt contain two variables with same name
		$this->constructTemplate = $npattern;
		return $this; //for chaining
	}
	
	public function getConstructTemplate(){
		return $this->constructTemplate;
	}
	
	public function setLimit($nlimit){
		if($this->isAskType()) return; //throw new RuntimeException("Trying to set solution modifier \"Limit\" in an ASK-Query - not possible");
		$this->limit = $nlimit;
		return $this; //for chaining
	}
	
	public function removeLimit(){
		$this->limit = 0;
		return $this; //for chaining
	}
	
	public function getLimit(){
		return $this->limit;
	}
	
	public function setOffset($noffset){
		if($this->isAskType()) return; //throw new RuntimeException("Trying to set solution modifier \"Offset\" in an ASK-Query - not possible");
		$this->offset = $noffset;
		return $this; //for chaining
	}
	
	public function removeOffset(){
		$this->offset = 0;
		return $this; //for chaining
	}
	
	public function getOffset(){
		return $this->offset;
	}
	
	public function setStar($bool){
		if($bool === true) $this->selectVars = array(); // delete projection vars if set to star mode - usefull?
		$this->star = $bool;
		return $this; //for chaining
	}
	
	public function isStar(){
		return count($this->selectVars) == 0 || $this->star;
	}
	
	public function setDistinct($bool){
		if($bool === true) $this->distinctReducedMode = 1;
		else if($this->distinctReducedMode == 1) 
			$this->distinctReducedMode = 0;
		return $this; //for chaining
	}
	
	public function isDistinct(){
		return $this->distinct;
	}
	
	public function setReduced($bool){
		if($bool === true) 
			$this->distinctReducedMode = 2;
		else if($this->distinctReducedMode == 2) 
			$this->distinctReducedMode = 0;
		return $this; //for chaining
	}
	
	public function isReduced(){
		return $this->reduced;
	}
	
	public function setBase(Erfurt_Sparql_Query2_IriRef $base){
		if($base->isPrefixed()) throw new RuntimeException("Trying to add base with a prefix");
		$this->base = $base;
		return $this; //for chaining
	}
	
	public function getBase($base){
		return $this->base;
	}
	
	public function hasBase(){
		return !empty($this->base);
	}
	
	public function addFrom($from){
		if(!is_a($from, "Erfurt_Sparql_Query2_GraphClause") && !is_a($from, "Erfurt_Sparql_Query2_IriRef") && !is_string($from)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2::addFrom must be an instance of Erfurt_Sparql_Query2_GraphClause or Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($setNamed)." given");
		}
		
		$named = false;
		
		if(is_a($from, "Erfurt_Sparql_Query2_IriRef"))
			$from = new Erfurt_Sparql_Query2_GraphClause($from);
		if(is_string($from))
			$from = new Erfurt_Sparql_Query2_GraphClause(new Erfurt_Sparql_Query2_IriRef($from));
		
		if(func_num_args()>1){
			$named = func_get_arg(1);
			if(!is_bool($named)){
				throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2::addFrom must be an instance of bool, instance of ".typeHelper($named)." given");
			}
			$from->setNamed($named);
		}
		
		$this->froms[] = $from;
		return $this; //for chaining
	}
	
	public function getFrom($i){
		return $this->froms[$i];
	}
	
	public function getFroms(){
		return $this->froms;
	}
	
	public function deleteFroms(){
		$this->froms = array();
	}
	
	public function deleteFrom($needle){
		if(!is_int($needle)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2::deleteFrom must be an instance of int, instance of ".typeHelper($needle)." given");
		}
		$new = array();
		for($i=0;$i<count($this->froms); $i++){
			if($i != $needle)
				$new[] = $this->froms[$i];
		}
		
		$this->froms = $new;
		return $this; //for chaining
	}
	
	public function setFroms($froms){
		if(!is_array($froms)){
			$tmp = $froms;
			$froms = array();
			$froms[0] = $tmp;
		}
		for($i=0;$i<count($froms); $i++){
			if(is_a($froms[$i], "Erfurt_Sparql_Query2_IriRef"))
				$froms[$i] = new Erfurt_Sparql_Query2_GraphClause($froms[$i]);
			if(is_string($froms[$i]))
				$froms[$i] = new Erfurt_Sparql_Query2_GraphClause(new Erfurt_Sparql_Query2_IriRef($froms[$i]));
		}
		
		$this->froms = $froms;
		return $this; //for chaining
	}
	
	public function setFrom($i, GraphClause $from){
		if(!is_int($i)) throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2::setFrom must be an instance of int, instance of ".typeHelper($i)." given");
		$this->froms[$i] = $from;
		return $this; //for chaining
	}
	
	public function hasFrom(){
		return !empty($this->froms);
	}
	
	public function addProjectionVar(Erfurt_Sparql_Query2_Var $var){
		if(in_array($var, $this->selectVars)){
			//already added
			return $this; //for chaining
		}
		
		if(!in_array($var, $this->where->getVars())){
			throw new RuntimeException("Trying to add projection-var that is not used in pattern");
			return $this; //for chaining
		}
		
		if(count($this->selectVars) == 0)
			$this->star = false; //if the first var is added: deactivate the star. maybe always?
		
		$this->selectVars[] = $var;
		return $this; //for chaining
	}
	
	public function addPrefix(Erfurt_Sparql_Query2_Prefix $prefix){
		$this->prefixes[] = $prefix;
		return $this; //for chaining
	}
	
	public function getProjectionVars(){
		return $this->selectVars;
	}
	
	public function getVars(){
		return $this->where->getVars();
	}
	
	public function getOrder(){
		//if($this->isAskType()) throw new RuntimeException("Trying to set solution modifier \"Order\" in an ASK-Query - not possible");
		return $this->order;
	}
	
	public function varFactory($name){
		$used = $this->where->getVars();
		for($i=0; $i < count($used); $i++){
			if($name == $used[$i]->getName()){
				return $used[$i];
			}
		}
		return new Erfurt_Sparql_Query2_Var($name);
	}
}
?>
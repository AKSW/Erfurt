<?php
require_once "Erfurt/Sparql/Query2.php";
require_once "Abstraction/ClassNode.php";
require_once "Abstraction/RDFSClass.php";
require_once "Abstraction/Link.php";
require_once "Abstraction/Utils.php";

//under construction
/**
 * Erfurt_Sparql Query - Abstraction.
 * 
 * an Abstraction for Sparql-Queries
 * 
 * @see			{@link http://code.google.com/p/Erfurt_Sparql/wiki/QueryObject Idea}
 * @package    query
 * @subpackage abstraction
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Abstraction
{
	protected $query;
	protected $startNode;
	
	protected $allowedCalls = array("addFrom", "getFrom", "setFrom", "getFroms", "setFroms", "addProjectionVar", "getOrder", "setLimit", "setOffset", "getLimit", "getOffset", "setDistinct", "setReduced", "getDistinct", "getReduced", "hasFrom");
	
	public function __construct($class = null, $withChilds = true, $varName = null, $member_predicate = EF_RDF_TYPE){
		$this->query = new Erfurt_Sparql_Query2();
		if($class != null && !($class instanceof Erfurt_Sparql_Query2_IriRef)){
			if(is_string($class)){
				$class = new Erfurt_Sparql_Query2_IriRef($class);
			} 
			if(!($class instanceof Erfurt_Sparql_Query2_IriRef))
				 throw new RuntimeException("Argument 3 passed to Erfurt_Sparql_Query2_Abstraction::addNode must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($class)." given");
		}
		
		//add startnode
		$this->startNode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($class, $member_predicate, $this->query, $varName, $withChilds);
	}
	
	
	public function __clone() {
	} 
	
	
	/**
	 * redirect method calls
	 */
	public function __call($name, $params){
		if(in_array($name, $this->allowedCalls)){
			return call_user_func_array(array($this->query, $name), $params); 
		} else throw new RuntimeException("Query2_Abstraction: method $name not found");
	}
	
	public function addNode(Erfurt_Sparql_Query2_Abstraction_ClassNode $sourceNode,  $LinkPredicate, $targetClass = null, $withChilds = true, $varName = null, $member_predicate = EF_RDF_TYPE){
		// hack for overloaded functioncalls
		if(!($LinkPredicate instanceof Erfurt_Sparql_Query2_IriRef)){
			if(is_string($LinkPredicate)){
				$LinkPredicate = new Erfurt_Sparql_Query2_IriRef($LinkPredicate);
			} else throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_Abstraction::addNode must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($LinkPredicate)." given");
		}
		
			if($targetClass == null){
				//TODO: find type of referenced objects
			}
			//add link from source node to new node
			$newnode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($targetClass, $member_predicate, $this->query, $varName, $withChilds);
			$sourceNode->addLink($LinkPredicate, $newnode);
			return $newnode; //for chaining

	}
	
	public function getSparql(){
		return $this->query->getSparql();
	}
	
	public function __toString(){
		return $this->getSparql();
	}
	
	public function getStartNode(){
		return $this->startNode;
	}
	
	public function getQueryClone(){
		return clone $this->query;
	}
}
?>

<?php

require_once "Abstraction/ClassNode.php";
require_once "Abstraction/RDFSClass.php";
require_once "Abstraction/Link.php";

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
	
	public function __construct(){
		$this->query = new Erfurt_Sparql_Query2();
	}
	
	public function addNode(Erfurt_Sparql_Query2_Abstraction_ClassNode $source = null, Erfurt_Sparql_Query2_IriRef $predicate = null, Erfurt_Sparql_Query2_Abstraction_RDFSClass $targetClass = null){
		if($source == null && $predicate == null){
			//add startnode
			$this->startNode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($targetClass, $this->query);
			return $this->startNode ;
		}
		
		if($source != null && $predicate != null){
			//add navigate from source node to new node
			$newnode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($targetClass, $this->query);
			$source->addLink($predicate, $newnode);
			return $newnode; //for chaining
		} else {
			throw new RuntimeException("Erfurt_Sparql_Query2_Abstraction::addNode : argument 1 and 2 must either both be null or both not null");
		}
	}
	
	public function getSparql(){
		return $this->query->getSparql();
	}
	
	public function getStartNode(){
		return $this->startNode;
	}
}
?>

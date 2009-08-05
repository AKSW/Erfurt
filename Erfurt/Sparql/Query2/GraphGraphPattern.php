<?php
require_once "GroupGraphPattern.php";

/**
 * Erfurt_Sparql Query - GraphGraphPattern.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

class Erfurt_Sparql_Query2_GraphGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern 
{
	protected $varOrIri;
	protected $ggp;
	
	public function __construct(Erfurt_Sparql_Query2_VarOrIri $nvarOrIri, Erfurt_Sparql_Query2_GroupGraphPattern $nggp){
		$this->varOrIri = $nvarOrIri;
		$this->ggp = $nggp;
	}
	
	public function __construct(){
		
	}
	
	public function setVarOrIri(Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri){
		$this->varOrIri = $nvarOrIri;
	}
	
	public function setGroupGraphPattern(Erfurt_Sparql_Query2_GroupGraphPattern $nggp){
		$this->ggp = $nggp;
	}
	
	public function getVarOrIri(){
		return $this->varOrIri;
	}
	
	public function getGroupGraphPattern(){
		return $this->ggp;
	}
	
	public function getSparql(){
		if(!$this->varOrIri || !$this->ggp){
			throw new RuntimeException("In Erfurt_Sparql_Query2_GraphGraphPattern: required fields not initialized yet");
		} else {
			return "GRAPH ".$this->varOrIri->getSparql()." ". $this->ggp->getSparql();
		}
	}
}
?>

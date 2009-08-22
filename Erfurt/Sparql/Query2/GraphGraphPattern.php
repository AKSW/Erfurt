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
	
	public function __construct(Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri){
		$this->varOrIri = $nvarOrIri;
	}
	
	public function setVarOrIri(Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri){
		$this->varOrIri = $nvarOrIri;
		return $this; //for chaining
	}
	
	public function getVarOrIri(){
		return $this->varOrIri;
	}
	
	public function getSparql(){
		return "GRAPH ".$this->varOrIri->getSparql()." ". substr(parent::getSparql(),0,-1); //subtr is cosmetic for stripping off the last linebreak 
	}
	
	public function getVars(){
		$vars = parent::getVars();
		if(is_a($this->varOrIri, "Erfurt_Sparql_Query2_Var"))
			$vars[] = $this->varOrIri;
		return $vars;
	}
}
?>

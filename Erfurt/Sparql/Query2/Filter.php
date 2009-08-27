<?php

/**
 * Erfurt_Sparql Query - Filter.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
 
class Erfurt_Sparql_Query2_Filter extends Erfurt_Sparql_Query2_ObjectHelper
{
	protected $element;
	
	public function __construct(Erfurt_Sparql_Query2_Constraint $element){
		$this->element = $element;
		parent::__construct();
	}
	
	public function getConstraint(){
	   return $this->element;
	}
	
	public function setConstraint(Erfurt_Sparql_Query2_Constraint $element){
	   $this->element = $element;
	   return $this;
	}
	
	public function getSparql(){
		$constraint_str = trim($this->element->getSparql());
		
		//grammar says: brackets are not needed , sparql engines say: error...
		if(substr($constraint_str, 0, 1) != "("){
			$constraint_str = "(".$constraint_str.")";
		}
		return "FILTER ".$constraint_str;
	}
	
	//TODO not implemented yet
	public function getVars(){
		return array();
	}
	
}
?>

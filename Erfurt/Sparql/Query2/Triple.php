<?php
/**
 * Erfurt_Sparql Query - Triple.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Triple extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
	protected $s;
	protected $p;
	protected $o;
	
	public function __construct(Erfurt_Sparql_Query2_VarOrTerm $ns, Erfurt_Sparql_Query2_Verb $np, Erfurt_Sparql_Query2_IF_ObjectList $no){
		$this->s=$ns;
		$this->p=$np;
		$this->o=$no;
		parent::__construct();
	}
	
	public function setS(Erfurt_Sparql_Query2_VarOrTerm $ns){
		$this->s=$ns;
		return $this; //for chaining
	}
	
	public function setP(Erfurt_Sparql_Query2_Verb $np){
		$this->p=$np;
		return $this; //for chaining
	}
	
	public function setO(Erfurt_Sparql_Query2_IF_ObjectList $no){
		$this->o=$no;
		return $this; //for chaining
	}
	
	public function getS(){
		return $this->s;
	}
	
	public function getP(){
		return $this->p;
	}
	
	public function getO(){
		return $this->o;
	}
	
	public function getSparql(){
		return $this->s->getSparql()." ".$this->p->getSparql()." ".$this->o->getSparql();
	}
	
	public function getVars(){
		$vars = array();
		
		if(is_a($this->s, "Erfurt_Sparql_Query2_Var")){
			$vars[] = $this->s;
		}
		if(is_a($this->p, "Erfurt_Sparql_Query2_Var")){
			$vars[] = $this->p;
		}
		if(is_a($this->o, "Erfurt_Sparql_Query2_Var")){
			$vars[] = $this->o;
		}
		
		return $vars;
	}
}
?>

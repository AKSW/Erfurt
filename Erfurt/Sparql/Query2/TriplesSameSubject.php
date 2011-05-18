<?php
/**
 * Erfurt Sparql Query2 - TriplesSameSubject
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: TriplesSameSubject.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */

class Erfurt_Sparql_Query2_TriplesSameSubject extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
	protected $subject;
	protected $propertyList = array();
	
	/**
	 * @param Erfurt_Sparql_Query2_VarOrTerm $subject
	 * @param array $propList array of (Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList)-pairs
	 */
	public function __construct(Erfurt_Sparql_Query2_VarOrTerm $subject, $propList = array()){
		$this->subject = $subject;
		if(!is_array($propList)){
			throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of '.typeHelper($propList).' given');
		} else {
			foreach($propList as $prop){
				if(!($prop['pred'] instanceof Erfurt_Sparql_Query2_Verb && $prop['obj'] instanceof Erfurt_Sparql_Query2_IF_ObjectList)){
					throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of '.typeHelper($prop).' given');
				} else {
					$this->propertyList[] = $prop;
				}
			}
		}
		
		parent::__construct();
	}
	
	/**
     * getSparql
     * build a valid sparql representation of this obj
     * @return string
     */
	public function getSparql(){
		$propList = '';
		
		for($i=0; $i<count($this->propertyList); $i++){
			$propList .= "\t".$this->propertyList[$i]['pred']->getSparql(). ' '.$this->propertyList[$i]['obj']->getSparql();
			if($i<(count($this->propertyList)-1)){
				$propList .=" ;\n";
			}
		}
		
		return $this->subject->getSparql().' '.$propList;
	}
	
	//TODO not implemented yet
    /**
     * getVars
     * get all vars used in this pattern (recursive)
     * @return array array of Erfurt_Sparql_Query2_Var
     */
	public function getVars(){
		return array();
	}
	
	/**
	 * getPropList
	 * @return array array of (Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList)-pairs
	 */
	public function getPropList(){
		return $this->propertyList;
	}
	
	/**
	 * getSubject
	 * @return Erfurt_Sparql_Query2_VarOrTerm the subject
	 */
	public function getSubject(){
		return $this->subject;
	}
	
}
?>

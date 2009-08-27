<?php
/**
 * OntoWiki
 * 
 * @package    
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

class Erfurt_Sparql_Query2_TriplesSameSubject extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
	protected $subject;
	protected $propertyList = array();

	public function __construct(Erfurt_Sparql_Query2_VarOrTerm $subject, $propList = array()){
		$this->subject = $subject;
		if(!is_array($propList)){
			throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of ".typeHelper($propList)." given");
		} else {
			foreach($propList as $prop){
				if(!is_a($prop["pred"], "Erfurt_Sparql_Query2_Verb") || !is_a($prop["obj"], "Erfurt_Sparql_Query2_IF_ObjectList")){
					throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of ".typeHelper($prop)." given");
				} else {
					$this->propertyList[] = $prop;
				}
			}
		}
		
		parent::__construct();
	}
	
	public function getSparql(){
		$propList = "";
		
		for($i=0; $i<count($this->propertyList); $i++){
			$propList .= "\t".$this->propertyList[$i]["pred"]->getSparql(). " ".$this->propertyList[$i]["obj"]->getSparql();
			if($i<(count($this->propertyList)-1)){
				$propList .=" ;\n";
			}
		}
		
		return $this->subject->getSparql()." ".$propList;
	}
	
	//TODO not implemented yet
	public function getVars(){
		return array();
	}
	
	public function getPropList(){
		return $this->propertyList;
	}
	
	public function getSubject(){
		return $this->subject;
	}
	
}
?>

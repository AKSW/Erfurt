<?php
/**
 * OntoWiki
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: RDFSClass.php 4131 2009-09-06 10:08:24Z jonas.brekle@gmail.com $
 */

class Erfurt_Sparql_Query2_Abstraction_RDFSClass
{
	protected $iri;
	protected $subclasses = array();
	protected $labels;
	
	public function __construct(Erfurt_Sparql_Query2_IriRef $iri, $withChilds = false){
		$this->iri = $iri;
		
 		if($withChilds){
			$owApp = OntoWiki_Application::getInstance();
			$store       = $owApp->erfurt->getStore();
	        $graph       = $owApp->selectedModel;
	        $types   = array_keys($store->getTransitiveClosure($graph->getModelIri(), EF_RDFS_SUBCLASSOF, array($iri->getIri()), true));
	        foreach($types as $type){
	        	$this->subclasses[] = new Erfurt_Sparql_Query2_IriRef($type);
	        }
 		}
	}
	
	public function getLabel($lang){
		if(isset($this->labels[$lang])){
			return $this->labels[$lang];
		} else {
			return $this->iri->getIri();
		}
	}
	
	public function getIri(){
		return $this->iri;
	}
	
	public function getSubclasses(){
		return $this->subclasses;
	}
}

//just a dummy
class Erfurt_Sparql_Query2_Abstraction_NoClass extends Erfurt_Sparql_Query2_Abstraction_RDFSClass {
	public function __construct(Erfurt_Sparql_Query2_IriRef $iri, $withChilds = false){
		parent::__construct($iri, $withChilds);
	}
}

?>

<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package    Erfurt_Sparql_Query2_Abstraction
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_Abstraction_RDFSClass
{
	protected $iri;
	protected $subclasses = array();
	protected $labels;
	
	public function __construct(Erfurt_Sparql_Query2_IriRef $iri, $withChilds = false){
		$this->iri = $iri;
		
 		if($withChilds){
// TODO what the heck???
			$owApp = OntoWiki::getInstance();
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

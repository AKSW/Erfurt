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

class Erfurt_Sparql_Query2_Abstraction_RDFSClass
{
	public $iri;
	public $labels;
	
	public function __construct(Erfurt_Sparql_Query2_IriRef $iri){
		$this->iri = $iri;
		
		if(func_num_args()>1){
			$labels = func_get_arg(1);
			if(is_array($labels)){
				$this->labels = $labels;
			} else {
				throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_Abstraction_RDFSClass::__construct must be an instance of array, instance of ".gettype($labels)." given");
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
}

?>

<?php
/**
 * Erfurt_Sparql Query - GraphTerm.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
  
class Erfurt_Sparql_Query2_Prefix //TODO must be unique in Query - factory?
{
	protected $name;
	protected $iri;
	
	public function __construct($nname, Erfurt_Sparql_Query2_IriRef $ref){
		if(!is_string($nname))
			
		$this->name = $nname;
		$this->iri = $ref;
	}
	
	public function getSparql(){
		return "PREFIX ".$this->name.": ".$this->iri->getSparql(); 
	}
}
?>

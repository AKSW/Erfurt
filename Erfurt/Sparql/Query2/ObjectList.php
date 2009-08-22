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

class Erfurt_Sparql_Query2_ObjectList implements Erfurt_Sparql_Query2_IF_ObjectList
{
	protected $objects = array();
	
	public function __construct ($objects){
		if(!is_array($objects)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_ObjectList::__construct must be an array of Erfurt_Sparql_Query2_GraphNode's, instance of ".typeHelper($objects)." given");
		} else {
			foreach($objects as $object){
				if(!is_a($object, "Erfurt_Sparql_Query2_GraphNode")){
					throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_ObjectList::__construct must be an array of Erfurt_Sparql_Query2_GraphNode's, instance of ".typeHelper($object)." given");
				} else {
					$this->objects[] = $object;
				}
			}
		}
	}
	
	public function getSparql(){
		return implode(", ", $this->objects);
	}
	
	public function __toString(){    
        return $this->getSparql();
    }
}
?>

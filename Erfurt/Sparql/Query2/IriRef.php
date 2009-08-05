<?php

require_once "Query2/VarOrIriRef.php";

/**
 * Erfurt_Sparql Query - IriRef.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_IriRef extends Erfurt_Sparql_Query2_VarOrIriRef{
	protected $iriRef;
	protected $prefix;
	
	public function __construct($nresource){
		if(!is_string($nresource)){throw new RuntimeException("wrong parameter for contructing Erfurt_Sparql_Query2_Variable. string expected. "+gettype($nresource)+" found.");}
		$this->iriRef = $nresource;
	}
	
	public function getSparql(){
		return $this->isPrefixed ? $this->prefix : "" . $this->iriRef;
	}
	
	public function isPrefixed(){
		return !empty($this->prefix);
	}
}
?>

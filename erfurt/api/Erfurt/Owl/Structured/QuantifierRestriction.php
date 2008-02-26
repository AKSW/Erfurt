<?php
/**
 * Superclass needed for creation of restrictions
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_QuantifierRestriction extends Erfurt_Owl_Structured_Restriction {
	
	public function __construct ( $uri , $onProperty , $fillerClass ) {
		
		$this->setURI ( $uri ) ;
		$this->setOnProperty ( $onProperty ) ;
		$this->addChildClass ( $fillerClass ) ;
	}

}
?>
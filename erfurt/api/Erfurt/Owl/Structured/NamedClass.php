<?php
/**
 * Erfurt Structured OWL representation of OWL Class
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_NamedClass extends Erfurt_Owl_Structured_StructuredClass {
	
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		return $this->getURI () ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$subject = new Resource ( $this->getURI () ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $subject, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model = $this->getMemModel () ;
		$model->add ( $statement ) ;
		return $model ;
	}
	
	public function toDIG1_1String () {
		
		return "<catom name=" . $this->getURI () . "/>" ;
	}

}
?>
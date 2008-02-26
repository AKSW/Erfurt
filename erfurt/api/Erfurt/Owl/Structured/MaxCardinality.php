<?php
/**
 * Erfurt Structured OWL implementation of the maxCardinality OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_MaxCardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " max " . $this->getCardinality () ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "maxCardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
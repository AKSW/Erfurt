<?php
/**
 * Erfurt Structured OWL implementation of the cardinality OWL Constructor
 * 
 *
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @version $Id$
 * @package owl
 **/

class Erfurt_Owl_Structured_Cardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	/**
	 * Generates Manchester OWL Syntax string
	 *
	 * @return sting Manchester OWL Syntax sting
	 **/
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " exactly " . $this->getCardinality () ;
	}
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "cardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
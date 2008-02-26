<?php
/**
 * Erfurt Structured OWL implementation of the minCardinality OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 */
class Erfurt_Owl_Structured_MinCardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " min " . $this->getCardinality () ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "minCardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
<?php
/**
 * Erfurt Structured OWL implementation of the allValuesFrom OWL Constructor
 * 
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version 
 **/
class Erfurt_Owl_Structured_AllValuesFrom extends Erfurt_Owl_Structured_QuantifierRestriction {

	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		$returnString = '[' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
			if ($key < count ( $children ) - 1) {
				$returnString .= ', ' ;
			}
		}
		$returnString .= ']' ;
		return "(" . $this->getOnProperty () . " only " . $returnString . ")" ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		
		$rangeString = '' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$rangeString .= $value->getURI () ;
			if ($key < count ( $children ) - 1) {
				$rangeString .= ', ' ;
			}
		}
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "allValuesFrom" ), new Resource ( $rangeString ) ) ;
		$model->add ( $statement ) ;
		return $model ;
	}

}
?>
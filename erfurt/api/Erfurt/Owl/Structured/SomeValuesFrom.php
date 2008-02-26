<?php
/**
 * Erfurt Structured OWL implementation of the someValuesFrom OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_SomeValuesFrom extends Erfurt_Owl_Structured_QuantifierRestriction {
	
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
		return "(" . $this->getOnProperty () . " some " . $returnString . ")" ;
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
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "someValuesFrom" ), new Resource ( $rangeString ) ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
<?php
/**
 * Erfurt Structured OWL implementation of the intersectionOf OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_IntersectionClass extends Erfurt_Owl_Structured_AnonymousClass {

	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		$returnString = '(' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
			if ($key < count ( $children ) - 1) {
				$returnString .= ' and ' ;
			}
		}
		return $returnString . ')' ;
	}

	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$this->getChildrenRDF();
		$predicate = new Resource ( $this->getURLPrefix (), "intersectionOf" ) ;
		$statement = new Statement ( $this->getSubject (), $predicate, $this->getFirstChildBlankNode() ) ;
		$model->add($statement);
		return $model ;
	}

	public function toDIG1_1String () {

		$returnString = '<and>' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $one ) {
			$returnString .= $one->toManchesterSyntaxString () ;
		}
		return $returnString . '</and>' ;
	}
}
?>
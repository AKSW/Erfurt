<?php

class Erfurt_Owl_Structured_IntersectionClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{
	
	public function __construct(){
		
	}
	
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
	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$predicate = new Resource ( $this->getURLPrefix (), "intersectionOf" ) ;
		$rangeString = '' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$rangeString .= $value->getURI () ;
			if ($key < count ( $children ) - 1) {
				$rangeString .= ' ' ;
			}
		}
		
		$statement = new Statement ( $this->getSubject (), $predicate, new Literal ( $rangeString ) ) ;
		$model->add ( $statement ) ;
		foreach ( $this->getChildClasses () as $value ) {
			$model->addModel ( $value->generateRDF () ) ;
		}
		return $model ;
	}

}
?>
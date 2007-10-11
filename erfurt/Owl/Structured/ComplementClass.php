<?php

class Erfurt_Owl_Structured_ComplementClass extends Erfurt_Owl_Structured_AnonymousClass 

{
	
	public function __construct ( $complementClass ) {
		parent::__construct ( 'not ' . $complementClass->getURI () ) ;
		$this->addChildClass ( $complementClass ) ;
	}
	
	public function toManchesterSyntaxString () {
		$returnString = '(' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
		}
		return "not " . $returnString . ")" ;
	}
	
	public function generateRDF () {
		
		//TODO description in _:x owl:complementOf T(description) =? manchesterstring
		

		$model = new Memmodel ( ) ;
		$blank = new BlankNode ( "_blankXXX" ) ;
		$subject = new Resource ( $blank->getID () ) ;
		
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $subject, $predicate, new Literal ( $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
		
		$children = $this->getChildClasses () ;
		$statement1 = new Statement ( $subject, new Resource ( $this->getURLPrefix () . "complementOf" ), new Literal ( $children [ 0 ]->getURI () ) ) ;
		$model->add ( $statement1 ) ;
		return $model ;
	}
	
	public function toDIG1_1String(){
		
		$returnString = '<not>' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $one ) {
			$returnString .= $one->toManchesterSyntaxString () ;
		}
		return $returnString . '</not>' ;
	}


}
?>
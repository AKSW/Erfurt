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
		

		$model = $this->getMemModel();
		$blank = new BlankNode ($model) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $blank, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
		$children=$this->getChildClasses();
		$child=$children[0];
		$model->addModel($child->generateRDF());
		$statement1 = new Statement ( $blank, new Resource ( $this->getURLPrefix () . "complementOf" ), $this->getFirstChildBlankNode() ) ;
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

	//TODO Finish this one!!!
	public function getFirstChildBlankNode(){
		$children=$this->getChildClasses();
		$child=$children[0];
		print_r($child);
		if(sizeof($child->getChildClasses())==1){
			return new Statement(new Resource($this->getURI()),new Resource($this->getRDFURL(),"type"),new Resource ( $this->getURLPrefix () . "Class" ));
		}
		else return new BlankNode($this->getMemModel());
	}

}
?>
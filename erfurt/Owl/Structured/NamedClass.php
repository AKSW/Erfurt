<?php

class Erfurt_Owl_Structured_NamedClass extends Erfurt_Owl_Structured_StructuredClass {
	
	public function toManchesterSyntaxString () {
		return $this->getURI () ;
	}
	
	public function generateRDF () {
		$subject = new Resource ( $this->getURI () ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $subject, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model = new MemModel ( ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
	
	public function toDIG1_1String(){
			
		return "<catom name=".$this->getURI ()."/>";
	}

}
?>
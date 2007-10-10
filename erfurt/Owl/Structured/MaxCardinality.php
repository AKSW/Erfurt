<?php

class Erfurt_Owl_Structured_MaxCardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " max " . $this->getCardinality () ;
	}
	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "MaxCardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_Cardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " exactly " . $this->getCardinality () ;
	}
	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "cardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
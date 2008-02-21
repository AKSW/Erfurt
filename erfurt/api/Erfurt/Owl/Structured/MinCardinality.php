<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_MinCardinality extends Erfurt_Owl_Structured_CardinalityBase 

{
	public function toManchesterSyntaxString () {
		return $this->getOnProperty () . " min " . $this->getCardinality () ;
	}
	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "minCardinality" ), $this->getCardinalityOWL () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}
}
?>
<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_SomeValuesFrom extends Erfurt_Owl_Structured_QuantifierRestriction {
	
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
	
	public function generateRDF () {
		
		$model = parent::generateRDF () ;
		$this->getChildrenRDF();
		/*$requiredString = '' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$requiredString .= $value->getURI () ;
			if ($key < count ( $children ) - 1) {
				$requiredString .= ', ' ;
			}
		}
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "someValuesFrom" ), new Literal ( $requiredString ) ) ;
		$model->add ( $statement ) ;
		*/
		return $model ;
	}
}
?>
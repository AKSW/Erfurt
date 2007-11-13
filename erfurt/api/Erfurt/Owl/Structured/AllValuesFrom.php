<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_AllValuesFrom extends Erfurt_Owl_Structured_QuantifierRestriction {
	//TODO check if allvaluesFrom is classExpr or instExpr in manchester.y
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
		return "(" . $this->getOnProperty () . " only " . $returnString . ")" ;
	}
	
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
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "allValuesFrom" ), new Resource ( $rangeString ) ) ;
		$model->add ( $statement ) ;
		return $model ;
	}

}
?>
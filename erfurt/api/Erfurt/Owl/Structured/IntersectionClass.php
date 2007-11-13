<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_IntersectionClass extends Erfurt_Owl_Structured_AnonymousClass {

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
<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_UnionClass extends Erfurt_Owl_Structured_AnonymousClass {

	public function toManchesterSyntaxString () {
		$returnString = '(' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $key => $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
			if ($key < count ( $children ) - 1) {
				$returnString .= ' or ' ;
			}
		}
		return $returnString . ')' ;
	}

	/**
	 * Enter description here...
	 *
	 * @return MemModel
	 */
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$predicate = new Resource ( $this->getURLPrefix (), "unionOf" ) ;
		$this->getChildrenRDF () ;
		$statement = new Statement ( $this->getSubject (), $predicate, $this->getFirstChildBlankNode () ) ;
		$model->add ( $statement ) ;
		return $model ;
	}

	public function toDIG1_1String () {

		$returnString = '<or>' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $one ) {
			$returnString .= $one->toManchesterSyntaxString () ;
		}
		return $returnString . '</or>' ;
	}
}
?>
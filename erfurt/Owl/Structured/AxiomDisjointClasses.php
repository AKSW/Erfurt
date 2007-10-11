<?php

class Erfurt_Owl_Structured_AxiomDisjointClasses extends Erfurt_Owl_Structured_Axiom  {


//not finished
	public function toManchesterSyntaxString () {
		$returnString = '(' ;
			$children = $this->getChildClasses () ;
			foreach ( $children as $value ) {
				$returnString .= $value->toManchesterSyntaxString () ;
			}
			return "not " . $returnString . ")" ;
	}
}
?>
<?php

class Erfurt_Owl_Structured_AxiomSubclass extends Erfurt_Owl_Structured_Axiom {



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
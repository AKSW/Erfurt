<?php
/**
 * RDFSLiteral
 * 
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004
 * @version $Id$
 */
abstract class Erfurt_Rdfs_Literal_Abstract extends Literal {
	
	protected $model;
	
	/**
	 * Constructor
	 * 
	 * @param Literal/string $label
	 * @param $language
	 * @param $datatype
	 * @return RDFSLiteral
	 **/
	public function __construct($label, $language = '', $datatype = '') {
		
		if ($label instanceof Literal) {
			Literal::Literal($label->getLabel(), $label->getLanguage());
			$this->setDatatype($label->getDatatype());
		} else {
			Literal::Literal($label, $language);
			$this->setDatatype($datatype);
		}
		
		//$this->model = $model;
	}
	
	public function __toString() {
		
		return 'RDFSLiteral("' . $this->label . '")<br />';
	}
}
?>

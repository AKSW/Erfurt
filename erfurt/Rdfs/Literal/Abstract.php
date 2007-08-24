<?php
/**
 * RDFSLiteral
 * 
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: literal.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
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

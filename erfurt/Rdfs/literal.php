<?php
/**
 * RDFSLiteral
 * 
 * @package RDFSAPI
 * @author S�ren Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: literal.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class DefaultRDFSLiteral extends Literal {
	
	var $model;
	/**
	 * Constructor
	 * 
	 * @param $label
	 * @param $language
	 * @param $datatype
	 * @return RDFSLiteral
	 **/
	function DefaultRDFSLiteral($label, $language = null, $datatype = null) {
		
		Literal::Literal($label,$language);
		
		if ($datatype !== null) $this->setDatatype($datatype);		
	}
}
?>
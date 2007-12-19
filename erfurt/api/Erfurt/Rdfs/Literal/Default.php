<?php
/**
 * TODO
 * 
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id: $
 */
class Erfurt_Rdfs_Literal_Default extends Literal {
	
	protected $model;
	
	/**
	 * Constructor
	 * 
	 * @param Literal/string $label
	 * @param $language
	 * @param $datatype
	 * @param $model
	 * @return Erfurt_Rdfs_Literal_Default
	 */
	public function __construct($label, $language = '', $datatype = '', $model = null) {
		
		if ($label instanceof Literal) {
			Literal::Literal($label->getLabel(), $label->getLanguage());
			$this->setDatatype($label->getDatatype());
		} else {
			Literal::Literal($label, $language);
			$this->setDatatype($datatype);
		}
		
		$this->model = $model;
	}
	
	public function __toString() {
		
		return 'Erfurt_Rdfs_Literal_Default("' . $this->label . '")<br />';
	}
}
?>

<?php
/**
 * Erfurt_Sparql Query - RDFLiteral.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */ 
class Erfurt_Sparql_Query2_RDFLiteral extends Erfurt_Sparql_Query2_GraphTerm
{
	protected $string = "";
	protected $datatype;
	protected $lang;
	protected $mode = 0;
	
	public function __construct ($str){
		$this->string = $str;

		if(func_num_args()>1){
			$meta = func_get_arg(1);
			if(is_string($meta)){
				$this->lang = $meta;
				$this->mode = 1;
			} else if (is_a($meta, "Erfurt_Sparql_Query2_IriRef")){
				$this->datatype = $meta;
				$this->mode = 2;
			} else {
				throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".gettype($meta)." given");
			}
		}
	}
	
	public function getSparql(){
		$sparql = "\"".$this->string."\"";
		
		switch($this->mode){
			case 0:
			break;
			case 1:
			$sparql .= "@".$this->lang;
			break;
			case 2:
			$sparql .= "^^".$this->datatype->getSparql();
			break;
		}
		
		return $sparql;
	}
}
?>

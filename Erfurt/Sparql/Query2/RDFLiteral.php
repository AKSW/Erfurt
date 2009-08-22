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
class Erfurt_Sparql_Query2_RDFLiteral implements Erfurt_Sparql_Query2_GraphTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
	protected $value = "";
	protected $datatype;
	protected $lang;
	protected $mode = 0;
	
	public function __construct($str){
		if(!is_string($str)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be a string, instance of ".typeHelper($str)." given");
		}
		$this->value = $str;

		if(func_num_args()>1){
			$meta = func_get_arg(1);
			if(is_string($meta)){
				switch($meta){
					case "int":
					case "boolean":
					case "float":
					case "decimal":
					case "string":
					case "time":
					case "date":
						$xmls="http://www.w3.org/2001/XMLSchema#";
						$this->datatype = new Erfurt_Sparql_Query2_IriRef($xmls.$meta);
						$this->mode = 2;
					break;
					default:
						$this->lang = $meta;
						$this->mode = 1;
					break;
				}
			} else if (is_a($meta, "Erfurt_Sparql_Query2_IriRef")){
				$this->datatype = $meta;
				$this->mode = 2;
			} else {
				throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($meta)." given");
			}
		}
	}
	
	public function getSparql(){
		$sparql = "\"".$this->value."\"";
		
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
	
	public function __toString(){
		return $this->getSparql();
	}
	
	public function setValue($val){
		if(is_string($val)){
			$this->value = $val;
		} else {
			//throw
		}
		return $this;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function setDatatype(Erfurt_Sparql_Query2_IriRef $type){
		$this->datatype = $type;
		return $this;
	}
	public function getDatatype(Erfurt_Sparql_Query2_IriRef $type){
		return $this->datatype;
	}
}
?>

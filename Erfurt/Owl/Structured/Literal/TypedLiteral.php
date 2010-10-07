<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 25, 2010
 * Time: 11:35:23 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Literal_TypedLiteral extends Erfurt_Owl_Structured_Literal{
    
    private $dataType;
    
    function __construct($value, $dataType) {
        parent::__construct($value);
        $this->setDataType($dataType);
    }

    public function setDataType($dataType){
        $this->dataType = $dataType;
    }

    public function getDataType(){
        return $this->dataType;
    }

    public function __toString() {
        return parent::__toString() . "^^" . $this->getDataType();
    }
}

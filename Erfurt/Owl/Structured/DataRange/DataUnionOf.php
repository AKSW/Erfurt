<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 4:41:36 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataRange_DataUnionOf extends Erfurt_Owl_Structured_DataRange{

    private $dataRanges=array();

    public function __construct($dataRange) {
        parent::__construct();
        $this->addElement($dataRange);
    }

    public function addElement(Erfurt_Owl_Structured_DataRange_DataIntersectionOf $element){
        $this->dataRanges []= $element;
    }

    public function __toString(){
        return implode(" or ", $this->dataRanges);
    }
}

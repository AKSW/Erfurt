<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 4:43:29 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataRange_DataIntersectionOf extends Erfurt_Owl_Structured_DataRange{

    private $dataRanges;

    public function addElement($dataPrimary){
        $this->dataRanges []= $dataPrimary;
    }

    function __toString() {
        return implode(" and ", $this->dataRanges);
    }

    function __construct($dataPrimary) {
        parent::__construct();
        $this->dataRanges = array();
        $this->addElement($dataPrimary);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 4:42:04 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataRange_DataOneOf extends Erfurt_Owl_Structured_DataRange{

    private $literals;

    function __construct(Erfurt_Owl_Structured_OwlList_LiteralList $list) {
        $this->literals = $list;
    }

    function __toString() {
        return "{" . $this->literals ."}";
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 4:38:55 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_DataRange {

    private $arity;

    function __construct() {
        // TODO: Implement __construct() method.
    }

    public function getArity(){
        return $this->arity;
    }

    public function setArity($newArity){
        $this->arity = $newArity;
    }
}

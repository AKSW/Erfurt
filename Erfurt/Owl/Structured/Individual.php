<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 2:31:55 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Individual implements Erfurt_Owl_Structured_IRdfPhp{

    private $value;

    function __construct($value) {
        $this->value = $value;
    }

    public function getValue(){
        return $this->value;
    }

    function __toString() {
        return "".$this->value;
    }

    public function toRdfArray() {
        return $this->value;
    }

}
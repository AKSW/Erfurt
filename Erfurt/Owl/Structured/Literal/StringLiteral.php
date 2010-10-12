<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 25, 2010
 * Time: 11:37:24 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Literal_StringLiteral extends Erfurt_Owl_Structured_Literal{

    private $languageTag;

    function __construct($value, $languageTag=null) {
        parent::__construct($value);
        if($languageTag)$this->setLanguageTag($languageTag);
    }

    public function getLang(){
        return $this->languageTag;
    }

    public function setLanguageTag($languageTag){
        $this->languageTag = $languageTag;
    }

    public function __toString() {
        return $this->languageTag ? parent::__toString() . "@" . $this->languageTag : parent::__toString();
    }

}

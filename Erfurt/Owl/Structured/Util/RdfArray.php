<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Sep 19, 2010
 * Time: 8:17:01 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Util_RdfArray {

    private static $id = 0;

    public static function createArray($subject, $predicate, $object, $lang=null, $dataType=null) {
        $rdfPhpType = null;
        $retval = array();

        var_dump($subject); var_dump($predicate); var_dump($object);

        if($object instanceof Erfurt_Owl_Structured_Literal) $rdfPhpType = "literal";
        else if(is_string($object)) $rdfPhpType = "bnode";
        else {
            $rdfPhpType = "uri";
            $retval []= self::drillDown($object,$subject);
        }
        
        $literal = array("type"=>$rdfPhpType, "value"=>$object);
        if($object instanceof Erfurt_Owl_Structured_Annotations_AnnotationValue){
            $literal["value"] = $object->getValue();
            if($object instanceof Erfurt_Owl_Structured_Literal_StringLiteral) $literal["lang"] = $object->getLang();
            if($object instanceof Erfurt_Owl_Structured_Literal_TypedLiteral) $literal["datatype"] = $object->getDataType();
        }
        if(isset($lang)) $literal["lang"] = $lang;
        if(isset($dataType)) $literal["datatype"] = $dataType->getValue();
        return $retval []= array($subject => array($predicate => array($literal)));
    }

    public static function getNewBnodeId(){
        return "_:b". ++self::$id;
    }

	public static function getCurrentBNodeId()
	{
		return "_:b". self::$id;
	}

    public static function drillDown($object, $subject){
//        var_dump($object);
        $elements = $object->getElements();
        $retval = array();
        if(count($elements)>1){
            foreach($elements as $element){
                $retval []= self::drillDown($element, self::getNewBnodeId());
            }
        } else $retval []= self::createArray($subject, $elements[0]->getPredicateString(), $elements[0]->getValue());
        return $retval;
    }
}
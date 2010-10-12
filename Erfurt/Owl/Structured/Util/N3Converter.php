<?php
 
class Erfurt_Owl_Structured_Util_N3Converter {

    public static function makeTriple($subject, $predicate, $object, $type=null){
      if($type) return $subject . " " . $predicate . " \"" . $object . "\"^^$type .\n" ;
        return $subject . " " . $predicate . " " . $object . " .\n" ;
    }
}

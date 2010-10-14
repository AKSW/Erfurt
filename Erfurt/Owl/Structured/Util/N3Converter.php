<?php
 
class Erfurt_Owl_Structured_Util_N3Converter {

//    public static function makeTriple($subject, $predicate, $object, $type=null){
//      if($type) return $subject . " " . $predicate . " \"" . $object . "\"^^$type .\n" ;
//        return $subject . " " . $predicate . " " . $object . " .\n" ;
//    }

    public static function makeTriplesFromArray($triples){
      if(!is_array($triples))
        throw new Exceptiopn("The triple must be converted to array!");
      else{
        $retval = "";
        foreach($triples as $triple){
          $retval .= $triple[0] . " " . 
            $triple[1] . " " .
            self::createObj($triple[2], count($triple)==4?$triple[3]:null) .
            " .\n";
        }
        return $retval;
      }
    }

    private static function createObj($o, $type=null){
      return $type? "\"" . $o . "\"^^$type" : $o;
    }
}

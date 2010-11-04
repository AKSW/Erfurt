<?php

class Erfurt_Owl_Structured_Util_N3Converter {

    public static function makeTriplesFromArray($triples) {
        if (!is_array($triples))
            throw new Exception("The triple must be converted to array!");
        else {
            $retval = "";
            foreach ($triples as $triple) {
                $retval .= $triple[0] . " " .
                        $triple[1] . " " .
                        self::createObj($triple[2], count($triple) == 4 ? $triple[3] : null) .
                        " .\n";
            }
            return $retval;
        }
    }

    private static function createObj($o, $type = null) {
        return $type ? "\"" . $o . "\"^^$type" : $o;
    }

    public static function makeList($elements) {
        $retval = array();
        $bnodeId = null;
        Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId();
        foreach ($elements as $key => $e) {
            if ($e->isComplex()) {
                $ee = $e->toArray();
                $retval [] = self::addFirst($bnodeId, $ee[0][0]);
                $retval = array_merge($retval, $ee);
            } else {
                $retval [] = self::addFirst($bnodeId, $e);
            }
            $retval [] = array(
                $bnodeId ? $bnodeId : Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
                "rdf:rest",
                $key == count($elements) - 1 ?
                        "rdf:nil" : ($bnodeId = Erfurt_Owl_Structured_Util_RdfArray::getNewBNodeId())
            );

        }
        return $retval;
    }

    private function addFirst($bnodeId, $value) {
        return array(
            $bnodeId ? $bnodeId : Erfurt_Owl_Structured_Util_RdfArray::getCurrentBNodeId(),
            "rdf:first",
            $value,
            ($value instanceof Erfurt_Owl_Structured_Literal ? $value->getDatatypeString() : null)
        );
    }
}

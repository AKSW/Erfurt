<?php

require_once 'Erfurt/Owl/Structured/Util/Constants.php';

/**
 * Class for creation of Structured OWL object from Data Store
 **/
class Erfurt_Owl_Structured_Util_Owl2Structured
{

//    function __construct($uriString)
//    {
//        $xxx = new Erfurt_Sparql_Query2();
//        $uri = new Erfurt_Sparql_Query2_IriRef($uriString);
//        $store = Erfurt_Owl_Structured_Util_SparqlHelper::getConnection();
//
//    }

    public static function mapOWL2Structured(array $from, $uri)
    {
      $sparqlHelper = new Erfurt_Owl_Structured_Util_SparqlHelper($from, $uri);
      $retval = $sparqlHelper->getStructuredOwl();
      return $retval;
        // $obj = $retval->query2StructuredOwl($q, $v1);
        // var_dump($obj);
        // var_dump((string)$q);

    }

//
//    private function checkClassExpression(Erfurt_Sparql_Query2 $q, $var)
//    {
//        $variable = ($var instanceof Erfurt_Sparql_Query2_Var) ? $var : new Erfurt_Sparql_Query2_Var($var);
//        $q->addElement(
//            Erfurt_Owl_Structured_Util_SparqlHelper::createTriple($variable,
//                    new Erfurt_Sparql_Query2_IriRef(Erfurt_Owl_Structured_Util_Constants::RDF_TYPE),
//                    "x")
//        );
//        $myQuery = clone $q;
//        $myQuery->setQueryType('SELECT');
//        $myQuery->addProjectionVar(new Erfurt_Sparql_Query2_Var("x"));
//        $retval = Erfurt_Owl_Structured_Util_SparqlHelper::fetch($myQuery);
//        // var_dump((string)$myQuery);
//        // var_dump($retval);
//        $o = Erfurt_Owl_Structured_Util_SparqlHelper::getReturnValue($retval);
//        switch ($o) {
//        case Erfurt_Owl_Structured_Util_SparqlHelper::OWL_RESTRICTION:
//            self::getRestriction($query, $variable);
//            break;
//
//        case Erfurt_Owl_Structured_Util_SparqlHelper::OWL_CLASS:
//            self::getConnectives($query, $variable);
//            break;
//        default:
//            // code...
//            break;
//        }
//
//    }
}

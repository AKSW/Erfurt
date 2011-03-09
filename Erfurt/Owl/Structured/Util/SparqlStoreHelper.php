<?php

/**
 * Helper class for store related stuff
 **/
class Erfurt_Owl_Structured_Util_SparqlStoreHelper
{

    public static function fetch($query) {
        return self::getConnection()->sparqlQuery($query/*, array('result_format' => 'turtle')*/);
    }

    public static function getConnection() {
        $store = Erfurt_App::getInstance()->getStore();
        $dbUser = $store->getDbUser();
        $dbPass = $store->getDbPassword();
        Erfurt_App::getInstance()->authenticate($dbUser, $dbPass);
        return $store;
    }

    public static function checkBuiltinFunction(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $variable, $builtin)
    {
      $builtinClass = "Erfurt_Sparql_Query2_" . $builtin;
      if (class_exists($builtinClass)) {
        $filter = new Erfurt_Sparql_Query2_Filter(
            new $builtinClass($variable));
        $myQuery = clone $q;
        $myQuery->addElement($filter);
        $myQuery->setQueryType('ASK');
        return (self::getReturnValue($myQuery)=="1") ? true : false;
      } else {
        throw new Exception("Class $builtinClass does not exist.");
      }
    }
//    public static function checkLiteral(Erfurt_Sparql_Query2 $query, Erfurt_Sparql_Query2_Var $variable)
//    {
//        $filter = new Erfurt_Sparql_Query2_Filter(
//            new Erfurt_Sparql_Query2_isLiteral($variable));
//        $myQuery = clone $query;
//        $myQuery->addElement($filter);
//        $myQuery->setQueryType('ASK');
//        return (self::getReturnValue($myQuery)=="1") ? true : false;
//    }
//
//    public static function checkBlank(Erfurt_Sparql_Query2 $query, Erfurt_Sparql_Query2_Var $variable)
//    {
//        $filter = new Erfurt_Sparql_Query2_Filter(
//            new Erfurt_Sparql_Query2_isBlank($variable));
//        $myQuery = clone $query;
//        $myQuery->addElement($filter);
//        $myQuery->setQueryType('ASK');
//        return (self::getReturnValue($myQuery)=="1") ? true : false;
//    }

    public static function getReturnValue(Erfurt_Sparql_Query2 $q)
    {
      $a = self::fetch($q);
        $retval = false;
        if(! is_array($a) || !count($a)) $retval = false;
        else if(is_array($a) && count($a) == 1)
            foreach ($a as $value)
            if (is_array($value))
                foreach ($value as $valueInternal) {
                $retval = $valueInternal;
                break;
            }
        return $retval;
    }

    public static function getVarValue(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $var)
    {
      $myQ = clone $q;
      $myQ->removeAllProjectionVars();
      $myQ->addProjectionVar($var);
      $myQ->setLimit(1);
      return self::getReturnValue($myQ);
    }

    // TODO why not sparql internal count?
    public static function count(Erfurt_Sparql_Query2 $q)
    {
      $a = self::fetch($q);
      return count($a);
    }
}

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

    public static function checkBlank(Erfurt_Sparql_Query2 $query, $variable)
    {
        $filter = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_isBlank(
              // TODO eliminate instanceof check
                ($variable instanceof Erfurt_Sparql_Query2_Var) ? $variable : new Erfurt_Sparql_Query2_Var($variable)));
        $myQuery = clone $query;
        $myQuery->addElement($filter);
        $myQuery->setQueryType('ASK');
        $isBlank = false;
        // var_dump((string)$myQuery);
        return (self::getReturnValue($myQuery)=="1") ? true : false;
    }

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

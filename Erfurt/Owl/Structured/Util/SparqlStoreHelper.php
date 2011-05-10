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
            if ($myQuery->hasLimit()) {
                $retval = self::getVarValue($myQuery, $variable);
                if($builtin == "isBlank") {
                  return strpos($retval, "nodeID") === 0;
                }
                elseif ($builtin == "isLiteral") {
                  return is_numeric($retval) || parse_url($retval) == false;
                }
                else return false;
            } else {
                $myQuery->addElement($filter);
                $myQuery->setQueryType('ASK');
                return (self::getReturnValue($myQuery)=="1") ? true : false;
            }
        } else {
            throw new Exception("Class $builtinClass does not exist.");
        }
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

    public static function count(Erfurt_Sparql_Query2 $q)
    {
        $a = self::fetch($q);
        return count($a);
    }

    public static function getRdfResource($modelIri, $classIri)
    {
        $store = self::getConnection();
        $model = $store->getModel($modelIri);
        $retval = $model->getResource($classIri)->getQualifiedName();
        /*
        $matches = array();
        preg_match('/^(.+[#\/])(.*[^#\/])$/', "http://purl.org/NET/c4dm/timeline.owl#Instant", $matches);
        if (!$retval) {
          $k=0;
          while(true){
            try{
              $model->addPrefix("ns".$k++,$matches[1]);
              $retval = $model->getResource($classIri)->getQualifiedName();
              //var_dump($retval);
              //var_dump($model->getNamespaces());
              break;
            } catch(Erfurt_Namespaces_Exception $e) {}
          }

        }*/
        // TODO eventually add the missing namespace to the model
        return ($retval) ? $retval : $model->getResource($classIri)->getIri();
    }

}

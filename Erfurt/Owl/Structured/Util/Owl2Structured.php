<?php

require_once 'Erfurt/Owl/Structured/Util/Constants.php';

/**
 * Class for creation of Structured OWL object from Data Store
 **/
class Erfurt_Owl_Structured_Util_Owl2Structured
{

    public static function mapOWL2Structured(array $from, $uri)
    {
      $sparqlHelper = new Erfurt_Owl_Structured_Util_SparqlHelper($from);
      // $retval = $sparqlHelper->getSubClass($uri);
      $retval = $sparqlHelper->getStructuredOwl($uri);
      return $retval;

    }
}

<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_SparqlHelperTest extends Erfurt_TestCase {

    public function TestConnection() {
        $x = Erfurt_Owl_Structured_Util_SparqlHelper::fetch();
        // var_dump($x);
    }

    public function testGreedy(){
        // $x = Erfurt_Owl_Structured_Util_SparqlHelper::fetch();
        // $query = "select * {?s ?p ?o}";
      //var_dump((string)
      Erfurt_Owl_Structured_Util_SparqlHelper::generateQuery(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Kontostand");
      // );
    }
}

<?php

require_once 'test_base.php';

/**
 * test class for Erfurt_Owl_Structured_Util_Sparql2OWL class
 **/
class Erfurt_Syntax_Manchester_Sparql2OWLTest extends Erfurt_TestCase
{
  
  function testQuery()
  {
    $val1 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Jahreshoechstlast");
    $this->assertEquals((string)$val1, "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Gasmenge");

    $val2 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Messpunkt");
    $this->assertEquals((string)$val2, "http://www.bi-web.de/ontologies/le4sw/ns/0.3/EIC exactly 1");
  }
}
?>

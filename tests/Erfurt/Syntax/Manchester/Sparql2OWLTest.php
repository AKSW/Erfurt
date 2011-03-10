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
    $this->assertEquals((string)($val1[0]), "ns0:Gasmenge");

    $val2 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Einspeisenetzbetreiber");
    $this->assertEquals((string)$val2[0], "ns0:Transportnetzbetreiber or ns0:Verteilnetzbetreiber");

    // $val3 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      // array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher");
    // $this->assertEquals((string)$val3, "http://www.bi-web.de/ontologies/le4sw/ns/0.3/EIC exactly 1");

    $val4 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://nwalsh.com/rdf/vCard#locality");
    $this->assertEquals((string)$val4[0], "http://xmlns.com/foaf/0.1/name exactly 1 (xsd:string)");

  }

  public function testNested()
  {
    $val5 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Allokation");
    $this->assertEquals((string)$val5[0], "ns0:allokiertFuer exactly 1 ns0:Ausspeisepunkt or ns0:Einspeisepunkt");

  }

  public function testMultiple()
  {
    $val5 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
      array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher");
    // var_dump($val5);
    foreach ($val5 as $val) {
      var_dump((string)$val);
    }
    // $this->assertEquals((string)$val5, "ddd");

  }

  function TestModel()
  {
        $store = Erfurt_App::getInstance()->getStore();
        $dbUser = $store->getDbUser();
        $dbPass = $store->getDbPassword();
        Erfurt_App::getInstance()->authenticate($dbUser, $dbPass);

        $model = $store->getModel('http://gasmarkt');
        // $resource = new Erfurt_Rdf_Resource('http://ns.ontowiki.net/SysOnt/Anonymous', $model);
        var_dump(
        $model->getResource("http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher")->getLocalName()
        );
        // var_dump($resource->getDescription());
  }
}
?>

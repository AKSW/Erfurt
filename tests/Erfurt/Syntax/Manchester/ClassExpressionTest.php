<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_ClassExpressionTest extends Erfurt_TestCase {

    private function initParser($inputQuery) {
        require_once 'antlr/Php/antlr.php';
        $input = new ANTLRStringStream($inputQuery);
        $lexer = new Erfurt_Syntax_ManchesterLexer($input);
        $tokens = new CommonTokenStream($lexer);
        return new Erfurt_Syntax_ManchesterParser($tokens);
    }

    /**
     * @dataProvider providerParser
     */
    public function TestParser($method, $inputQuery, $expectedValue) {
        $q = $this->initParser($inputQuery)->$method();
        $triples = $q->toTriples();
        var_dump(serialize($q));
        var_dump($q->__toString());
        $this->assertEquals($expectedValue, $triples);
    }

    public function providerParser() {
      $resourceDir = "resources/manchester/classExpression/";
      $owlFile = $resourceDir . "intersection.owl";
      $manFile = $resourceDir . "intersection.man";

      $f1 = fopen($owlFile, "r");
      $f2 = fopen($manFile, "r");

      return array(
                      array("description",fread($f2,filesize($manFile)), fread($f1, filesize($owlFile))));
      fclose ($f1);
      fclose ($f2);
    }

    public function testDb(){
//        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        
//        $store->getNewModel('http://gasmarkt');
        var_dump($store);
//        $store->importRdf('http://od.fmi.uni-leipzig.de/model/', self::RDF_TEST_DIR.'fmi.rdf', 'rdf');
        
//        $store->getNewModel('http://od.fmi.uni-leipzig.de/s10/');
//        $store->importRdf('http://od.fmi.uni-leipzig.de/s10/', self::RDF_TEST_DIR.'fmi-s10.rdf', 'rdf');
    }
}

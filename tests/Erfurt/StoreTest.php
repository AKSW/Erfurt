<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Store.php';

class Erfurt_StoreTest extends Erfurt_TestCase
{    
    public function testExistence()
    {
        $this->assertTrue(class_exists('Erfurt_Store'));
    }
    
    public function testImportRdfFrom303Url()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $url = 'http://ns.softwiki.de/req/';
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $store->getNewModel($url, false);
        
        try {
            $store->importRdf($url, $url, 'auto', Erfurt_Syntax_RdfParser::LOCATOR_URL, false);
        } catch (Erfurt_Exception $e) {
            $store->deleteModel($url, false);
            $this->fail($e->getMessage());
        }
        
        $store->deleteModel($url, false);
    }
    
    /**
     * This test is introduced in order to reproduce issue 404 (n changing multiple literals, new triples will created)
     */
    public function testDeleteMatchingStatementsMatchSubject()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $modelUri = 'http://example.org/deleteTest/';
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel($modelUri, false);
        
        
        $turtleString = '<http://model.org/model#localName> a 
                            <http://model.org/model#className1>, <http://model.org/model#className2> ;
                            <http://www.w3.org/2000/01/rdf-schema#label> "label1", "label2"@nl .';
        
        $store->importRdf($modelUri, $turtleString, 'turtle', Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, false);
        
        $sparql = 'SELECT * FROM <http://example.org/deleteTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);

        $this->assertEquals(5, count($result));
        
        $store->deleteMatchingStatements($modelUri, 'http://model.org/model#localName', null, null);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals(1, count($result));
    }
}




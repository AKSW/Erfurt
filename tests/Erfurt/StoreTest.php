<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser.php';
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
            $this->fail($e->getMessage());
        }
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
    
    public function testDeleteMatchingStatementsIssue436MultipleLanguageTags()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $modelUri = 'http://example.org/deleteTest/';
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel($modelUri, false);
        
        
        $turtleString = '@base <http://bis.ontowiki.net/> .
                    @prefix bis: <http://bis.ontowiki.net/> .
                    @prefix dc: <http://purl.org/dc/elements/1.1/> .
                    @prefix ldap: <http://purl.org/net/ldap#> .
                    @prefix swrc: <http://swrc.ontoware.org/ontology#> .
                    @prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
                    @prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
                    @prefix owl: <http://www.w3.org/2002/07/owl#> .
                    @prefix ns: <http://www.w3.org/2003/06/sw-vocab-status/ns#> .
                    @prefix foaf: <http://xmlns.com/foaf/0.1/> .
                    @prefix wot: <http://xmlns.com/wot/0.1/> .

                    bis:PeterPan ldap:mobile "+49 XXX 123456" ;
                         ldap:roomNumber "5-XX" ;
                         ldap:telephoneNumber "+49 341 123456" ;
                         a swrc:FacultyMember ;
                         rdfs:label "Peter Pan 2 de"@de, "Peter Pan 2 nl"@nl, "Peter Pan nl"@nl ;
                         foaf:firstName "Peter" ;
                         foaf:icqChatID "123-456-789" ;
                         foaf:mbox <mailto:peter.pan@informatik.uni-leipzig.de> ;
                         foaf:surname "PanPühn" .';
        
        $store->importRdf($modelUri, $turtleString, 'turtle', Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, false);
        
        $sparql = 'SELECT * FROM <http://example.org/deleteTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);

        $this->assertEquals(12, count($result));
        
        $store->deleteMatchingStatements($modelUri, 'http://bis.ontowiki.net/PeterPan', null, null);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals(1, count($result));
    }
    
    public function testCheckSetupWithZendDb()
    {
        $this->markTestNeedsCleanZendDbDatabase();
        $this->markTestUsesDb();
        
        $store = Erfurt_App::getInstance()->getStore();
        $config = Erfurt_App::getInstance()->getConfig();
        
        try {
            $store->checkSetup();
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
        
        $this->assertTrue($store->isModelAvailable($config->sysont->schemaUri, false));
        $this->assertTrue($store->isModelAvailable($config->sysont->modelUri, false));
    }
    
    public function testGetGraphsUsingResource()
    {
        $this->markTestNeedsDatabase();
        
        $resource = 'http://localhost/OntoWiki/Config/';
        $store = Erfurt_App::getInstance()->getStore();
        
        $graphs = $store->getGraphsUsingResource($resource, false);
        
        $this->assertTrue(in_array($resource, $graphs));
    }
    
    public function testSparqlQueryWithCountQueryAndEmptyResultIssue174()
    {
        $this->markTestNeedsDatabase();
        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $query = 'COUNT WHERE { ?s ?p "SomethingThatDoesNotExistsIGUUGIZFZTFVBhjscjkggniperegrthhrt" . }';
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $simpleQuery = Erfurt_Sparql_SimpleQuery::initWithString($query);
        
        $result = $store->sparqlQuery($simpleQuery);
        $this->assertEquals(0, $result);
    }
    
    public function testSparqlQueryWithCountAndFromIssue174()
    {
        $this->markTestNeedsDatabase();
        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $query = 'COUNT 
                  FROM <http://localhost/OntoWiki/Config/> 
                  WHERE { 
            ?s ?p ?o . 
        }';
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $simpleQuery = Erfurt_Sparql_SimpleQuery::initWithString($query);
        
        $result = $store->sparqlQuery($simpleQuery);
        
        $this->assertEquals(191, $result);
    }
    
    public function testCountWhereMatchesWithNonExistingModel()
    {
        $this->markTestNeedsDatabase();
        
        $store = Erfurt_App::getInstance()->getStore();
        
        try {
            $result = $store->countWhereMatches(
                'http://localhost/SomeModelThatDoesNotExist123456789', 
                '{ ?s ?p ?o }',
                '*'
            );
            
            // Should fail...
            $this->fail();
        } catch (Erfurt_Store_Exception $e) {
            // Nothing to do here...
        }
    }
    
    public function testSparqlQueryWithSpecialCharUriIssue579()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        $store = Erfurt_App::getInstance()->getStore();
        
        $sparql = "SELECT ?p ?o WHERE { <http://umg.kurtisrandom.com/resource/genre-Children's> ?p ?o . }";
        $simpleQuery = Erfurt_Sparql_SimpleQuery::initWithString($sparql);
        $result = $store->sparqlQuery($simpleQuery);
        $this->assertTrue(is_array($result));
    }
}




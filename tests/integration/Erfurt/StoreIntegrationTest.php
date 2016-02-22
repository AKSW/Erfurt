<?php

/**
 * @group Integration
 */
class Erfurt_StoreIntegrationTest extends Erfurt_TestCase
{
    private $_fileBase = null;

    public function setUp()
    {
        $this->_fileBase = realpath(dirname(__FILE__)) . '/_files/';

        parent::setUp();
    }

    /*public function testImportRdfFrom303Url()
    {
// TODO fix this by using a http test client!
        $this->markTestIncomplete();

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
    }*/
    
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

        $sparql = 'SELECT * FROM <http://example.org/deleteTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);
        $initialTriples = count($result);

        // Turtle string with 4 triples.
        $turtleString = '<http://model.org/model#localName> a <http://model.org/model#className1>,
                                                              <http://model.org/model#className2> ;
                                             <http://www.w3.org/2000/01/rdf-schema#label> "label1",
                                                                                          "label2"@nl .';
        
        $store->importRdf($modelUri, $turtleString, 'turtle', Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, false);
        
        $sparql = 'SELECT * FROM <http://example.org/deleteTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);

        $this->assertEquals($initialTriples + 4, count($result));
       
        $store->deleteMatchingStatements($modelUri, 'http://model.org/model#localName', null, null);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals($initialTriples, count($result));
    }
    
    public function testDeleteMatchingStatementsIssue436MultipleLanguageTags()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $modelUri = 'http://example.org/deleteTest/';
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel($modelUri, false);

        $sparql = 'SELECT * FROM <http://example.org/deleteTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);
        $initialTriples = count($result);

        // Turtle string with 11 triples.
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

        $this->assertEquals($initialTriples + 11, count($result));
        
        $store->deleteMatchingStatements($modelUri, 'http://bis.ontowiki.net/PeterPan', null, null);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals($initialTriples, count($result));
    }
    
    public function testCheckSetupWithZendDb()
    {
        $this->markTestNeedsCleanZendDbDatabase();
        
        $store = Erfurt_App::getInstance()->getStore();
        $config = Erfurt_App::getInstance()->getConfig();

        $store->checkSetup();
        
        $this->assertTrue($store->isModelAvailable($config->sysont->schemaUri, false));
        $this->assertTrue($store->isModelAvailable($config->sysont->modelUri, false));
    }
    
    public function testGetGraphsUsingResource()
    {
        $this->markTestNeedsDatabase();
        
        $resource = 'http://localhost/OntoWiki/Config/';
        $store = Erfurt_App::getInstance()->getStore();
        
        $graphs = $store->getGraphsUsingResource($resource, false);
        
        $this->assertContains($resource, $graphs);
    }
    
    public function testSparqlQueryWithCountQueryAndEmptyResultIssue174()
    {
        // Issue: https://github.com/Matthimatiker/Erfurt/issues/8
        $this->markTestSkipped('TODO: Currently, this test works neither on Travis (Ubuntu) nor on Win7.');

        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $query = 'COUNT WHERE { ?s ?p "SomethingThatDoesNotExistsIGUUGIZFZTFVBhjscjkggniperegrthhrt" . }';
        
        $simpleQuery = Erfurt_Sparql_SimpleQuery::initWithString($query);
        
        $result = $store->sparqlQuery($simpleQuery);
        $this->assertEquals(0, $result);
    }
    
    public function testSparqlQueryWithCountAndFromIssue174()
    {
        // Issue: https://github.com/Matthimatiker/Erfurt/issues/8
        $this->markTestSkipped('TODO: Currently, this test works neither on Travis (Ubuntu) nor on Win7.');

        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $query = 'COUNT 
                  FROM <http://localhost/OntoWiki/Config/> 
                  WHERE { 
            ?s ?p ?o . 
        }';
        
        $simpleQuery = Erfurt_Sparql_SimpleQuery::initWithString($query);
        $result = $store->sparqlQuery($simpleQuery);

        $this->assertEquals(208, $result);
    }
    
    public function testCountWhereMatchesWithNonExistingModel()
    {
        $this->markTestNeedsDatabase();
        
        $store = Erfurt_App::getInstance()->getStore();

        $this->setExpectedException('Erfurt_Store_Exception');
        $store->countWhereMatches(
            'http://localhost/SomeModelThatDoesNotExist123456789',
            '{ ?s ?p ?o }',
            '*'
        );
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
    
    public function testGetImportsClosureMultipleCallsWithDifferentParameters()
    {
        $this->markTestNeedsDatabase();
        $store = Erfurt_App::getInstance()->getStore();

        $importClosure1 = $store->getImportsClosure('http://localhost/OntoWiki/Config/', false, true); // no hidden imports, with ac
        $this->assertEquals(0, count($importClosure1));

        $importClosure2 = $store->getImportsClosure('http://localhost/OntoWiki/Config/', true, false); // with hidden imports, no ac
        // Should be 1 in this case (sys ont schema)
        $this->assertEquals(1, count($importClosure2));
    }

    /**
     * We create this test for all backends (although it seems to be an Virtuoso issue), since testing of data import
     * should be useful for all backends.
     */
    public function testImportRdfXmlWithVirtuosoGeoDatatypeOnlyAvailableInCommercialVersionGithubIssue85()
    {
        // Issue: https://github.com/Matthimatiker/Erfurt/issues/9
        $message = 'TODO: Currently, this test fails on a Win7 installation. '
                 . 'It will be skipped until it is clear how to proceed.';
        $this->skipIfWindows($message);

        $this->markTestNeedsDatabase();
        $store = Erfurt_App::getInstance()->getStore();

        $dataPath = $this->_fileBase . 'Grieg_Hall.xml';

        $graphUri = 'http://example.org/testGraph1/';

        // create graph
        $store->getNewModel($graphUri, '', Erfurt_Store::MODEL_TYPE_OWL, false);

        // import RDF
        $result = $store->importRdf($graphUri, $dataPath, 'auto', Erfurt_Syntax_RdfParser::LOCATOR_FILE);

        $this->assertTrue($result);
    }

    public function testImportDBPediaResourceAutomobileAndQueryWithTitleHelperQueryGithubIssue85()
    {
        // Issue: https://github.com/Matthimatiker/Erfurt/issues/9
        $message = 'TODO: Currently, this test fails on a Win7 installation. '
                 . 'It will be skipped until it is clear how to proceed.';
        $this->skipIfWindows($message);

        $this->markTestNeedsDatabase();
        $store = Erfurt_App::getInstance()->getStore();

        $dataPath = $this->_fileBase . 'Automobile.xml';

        $graphUri = 'http://example.org/testGraphAutomobile/';

        // create graph
        $store->getNewModel($graphUri, '', Erfurt_Store::MODEL_TYPE_OWL, false);

        // import RDF
        $result = $store->importRdf($graphUri, $dataPath, 'auto', Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        $this->assertTrue($result);

        // sparql
        $sparql = <<<EOF
SELECT DISTINCT ?property ?value
FROM <http://example.org/testGraphAutomobile/>
WHERE {
    OPTIONAL { <$graphUri> ?property ?value . }
    FILTER(
        sameTerm(?property, <http://www.w3.org/2004/02/skos/core#prefLabel>) ||
        sameTerm(?property, <http://purl.org/dc/elements/1.1/title>) ||
        sameTerm(?property, <http://purl.org/dc/terms/title>) ||
        sameTerm(?property, <http://swrc.ontoware.org/ontology#title>) ||
        sameTerm(?property, <http://xmlns.com/foaf/0.1/name>) ||
        sameTerm(?property, <http://usefulinc.com/ns/doap#name>) ||
        sameTerm(?property, <http://rdfs.org/sioc/ns#name>) ||
        sameTerm(?property, <http://www.holygoat.co.uk/owl/redwood/0.1/tags/name>) ||
         sameTerm(?property, <http://linkedgeodata.org/vocabulary#name>) ||
         sameTerm(?property, <http://www.geonames.org/ontology#name>) ||
         sameTerm(?property, <http://www.geneontology.org/dtds/go.dtd#name>) ||
         sameTerm(?property, <http://www.w3.org/2000/01/rdf-schema#label>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/accountName>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/nick>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/surname>) ||
         sameTerm(?property, <http://www.w3.org/2004/02/skos/core#altLabel>)
    )
}
EOF;

        $sparqlResult = $store->sparqlQuery(
            $sparql,
            array(
                 Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED,
                 Erfurt_Store::USE_AC => false
            )
        );

        $this->assertInternalType('array', $sparqlResult);
        $this->assertNotEmpty($sparqlResult);
    }

    public function testImportDBPediaResourceMachineLearningAndQueryWithTitleHelperQueryGithubIssue85()
    {
        // Issue: https://github.com/Matthimatiker/Erfurt/issues/9
        $message = 'TODO: Currently, this test fails on a Win7 installation. '
                 . 'It will be skipped until it is clear how to proceed.';
        $this->skipIfWindows($message);

        $this->markTestNeedsDatabase();
        $store = Erfurt_App::getInstance()->getStore();

        $dataPath = $this->_fileBase . 'Machine_learning.xml';

        $graphUri = 'http://example.org/testGraphMLXyz';

        // create graph
        $store->getNewModel($graphUri, '', Erfurt_Store::MODEL_TYPE_OWL, false);

        // import RDF
        $result = $store->importRdf($graphUri, $dataPath, 'auto', Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        $this->assertTrue($result);

        // sparql
        $sparql = <<<EOF
SELECT DISTINCT ?property ?value
FROM <$graphUri/>
WHERE {
    OPTIONAL { <http://dbpedia.org/resource/Machine_learning> ?property ?value . }
    FILTER(
        sameTerm(?property, <http://www.w3.org/2004/02/skos/core#prefLabel>) ||
        sameTerm(?property, <http://purl.org/dc/elements/1.1/title>) ||
        sameTerm(?property, <http://purl.org/dc/terms/title>) ||
        sameTerm(?property, <http://swrc.ontoware.org/ontology#title>) ||
        sameTerm(?property, <http://xmlns.com/foaf/0.1/name>) ||
        sameTerm(?property, <http://usefulinc.com/ns/doap#name>) ||
        sameTerm(?property, <http://rdfs.org/sioc/ns#name>) ||
        sameTerm(?property, <http://www.holygoat.co.uk/owl/redwood/0.1/tags/name>) ||
         sameTerm(?property, <http://linkedgeodata.org/vocabulary#name>) ||
         sameTerm(?property, <http://www.geonames.org/ontology#name>) ||
         sameTerm(?property, <http://www.geneontology.org/dtds/go.dtd#name>) ||
         sameTerm(?property, <http://www.w3.org/2000/01/rdf-schema#label>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/accountName>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/nick>) ||
         sameTerm(?property, <http://xmlns.com/foaf/0.1/surname>) ||
         sameTerm(?property, <http://www.w3.org/2004/02/skos/core#altLabel>)
    )
}
EOF;

        $sparqlResult = $store->sparqlQuery(
            $sparql,
            array(
                 Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED,
                 Erfurt_Store::USE_AC => false
            )
        );

        $this->assertInternalType('array', $sparqlResult);
        $this->assertNotEmpty($sparqlResult);
    }
}




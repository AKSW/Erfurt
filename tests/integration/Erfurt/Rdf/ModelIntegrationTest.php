<?php

class Erfurt_Rdf_ModelIntegrationTest extends Erfurt_TestCase
{
    protected $_storeStub = null;
    
    public function setUp()
    {
        $this->_storeStub = new Erfurt_Rdf_StoreStub();
    }
    
    protected function _getMockedModel()
    {        
        $model = $this->getMock('Erfurt_Rdf_Model', // original class name
            array('getStore'),                      // method to mock
            array('http://example.org/')            // constructor params
        );
        $model->expects($this->any())
              ->method('getStore')
              ->will($this->returnValue($this->_storeStub));
        
        return $model;
    }
    
    public function testUpdateWithMutualDifferenceIssue436DifferentLanguages()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $modelUri = 'http://example.org/updateTest/';
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel($modelUri);

        $sparql = 'SELECT * FROM <http://example.org/updateTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);
        $initialTriples = count($result);

        // Turtle string with 11 statements:
        $turtle1 = '@base <http://bis.ontowiki.net/> .
                    @prefix bis: <http://bis.ontowiki.net/> .
                    @prefix dc: <http://purl.org/dc/elements/1.1/> .
                    @prefix ldapns: <http://purl.org/net/ldap#> .
                    @prefix swrc: <http://swrc.ontoware.org/ontology#> .
                    @prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
                    @prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
                    @prefix owl: <http://www.w3.org/2002/07/owl#> .
                    @prefix ns: <http://www.w3.org/2003/06/sw-vocab-status/ns#> .
                    @prefix foaf: <http://xmlns.com/foaf/0.1/> .
                    @prefix wot: <http://xmlns.com/wot/0.1/> .

                    bis:PeterPan ldapns:mobile "+49 XXX 123456" ;
                         ldapns:roomNumber "5-XX" ;
                         ldapns:telephoneNumber "+49 341 123456" ;
                         a swrc:FacultyMember ;
                         rdfs:label "Peter Pan 2 de"@de, "Peter Pan 2 nl"@nl, "Peter Pan nl"@nl ;
                         foaf:firstName "Peter" ;
                         foaf:icqChatID "123-456-789" ;
                         foaf:mbox <mailto:peter.pan@informatik.uni-leipzig.de> ;
                         foaf:surname "PanPühn" .';

        // Turtle string with 9 triples:
        $turtle2 = '@base <http://bis.ontowiki.net/> .
                    @prefix bis: <http://bis.ontowiki.net/> .
                    @prefix dc: <http://purl.org/dc/elements/1.1/> .
                    @prefix ldapns: <http://purl.org/net/ldap#> .
                    @prefix swrc: <http://swrc.ontoware.org/ontology#> .
                    @prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
                    @prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
                    @prefix owl: <http://www.w3.org/2002/07/owl#> .
                    @prefix ns: <http://www.w3.org/2003/06/sw-vocab-status/ns#> .
                    @prefix foaf: <http://xmlns.com/foaf/0.1/> .
                    @prefix wot: <http://xmlns.com/wot/0.1/> .

                    bis:PeterPan ldapns:mobile "+49 XXX 123456" ;
                          ldapns:roomNumber "5-XX" ;
                          ldapns:telephoneNumber "+49 341 123456" ;
                          a swrc:FacultyMember ;
                          rdfs:label "Peter Pan 2 de"@de ;
                          foaf:firstName "Peter" ;
                          foaf:icqChatID "123-456-789" ;
                          foaf:mbox <mailto:peter.pan@informatik.uni-leipzig.de> ;
                          foaf:surname "PanPühn" .';
                       
        $turtleParser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('turtle');
        
        $store->importRdf('http://example.org/updateTest/', $turtle1, 'turtle',
            Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, false);
        $statements1 = $turtleParser->parse($turtle1, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
        $turtleParser->reset();
        $statements2 = $turtleParser->parse($turtle2, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);


        $result = $model->sparqlQuery($sparql);

        $this->assertEquals($initialTriples + 11, count($result));
        
        $model->updateWithMutualDifference($statements1, $statements2);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals($initialTriples + 9, count($result));
    }
    
    public function testAddAndGetAndDeleteNamespacePrefix()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
    
        $model = $store->getNewModel('http://example.org/namespaceTest/', '', 'owl', false);

        // add a test prefix to the model
        $model->addNamespacePrefix("test","http://testhausen/foo/bar/");

        // get prefixes from the model and test if added prefix exists
        $prefixes = $model->getNamespacePrefixes();
        $this->assertArrayHasKey("test", $prefixes);
        $this->assertEquals("http://testhausen/foo/bar/", $prefixes["test"]);

        // delete test prefix
        $model->deleteNamespacePrefix("test");

        // check if it is deleted
        $prefixes = $model->getNamespacePrefixes();
        $this->assertFalse(array_key_exists("test", $prefixes));
    }
    
    public function testSetGetOption()
    {
        $this->markTestNeedsDatabase();
        
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel('http://example.org/', 'http://example.org/', 'owl', false);

        $testProp = 'http://ns.ontowiki.net/SysOnt/foobartest';
        $optionIn = array();
        $optionIn[] = array(
            'value' => 'testliteralfoobar',
            'type'  => 'literal'
        );

        $model->setOption($testProp, $optionIn);
        $optionOut = $model->getOption($testProp);

        $this->assertEquals($optionIn, $optionOut);
    }
    
    public function testIsEditableWithZendDbAndAnonymousUserIssue774()
    {
        $this->markTestNeedsZendDb();
        
        //$this->authenticateDbUser();
        $store = Erfurt_App::getInstance()->getStore();
        $store->getNewModel('http://example.org/', 'http://example.org/', 'owl', false);
        $ac = Erfurt_App::getInstance()->getAc();
        $ac->setUserModelRight('http://example.org/', 'edit', 'deny');
        
        $this->authenticateAnonymous();
        $model = $store->getModel('http://example.org/');
        $this->assertTrue($model instanceof Erfurt_Rdf_Model);
        $this->assertFalse($model->isEditable());
        
        $ac->setUserModelRight('http://example.org/', 'view', 'deny');
        try {
            $model = $store->getModel('http://example.org/');
            
            $this->fail('Model should not be readable here.');
        } catch (Exception $e) {
            
        }
    }

    public function testRenameResource()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();

        $modelUri = 'http://example.org/renameTest/';
        $store = Erfurt_App::getInstance()->getStore();

        $graphs = array();
        foreach (array('old', 'new') as $diff) {
            $graphs[$diff] = array(
                $modelUri => array(
                    EF_RDF_TYPE => array(
                        array('value' => EF_OWL_ONTOLOGY, 'type' => 'uri'),
                    ),
                ),
                $modelUri.$diff => array(
                    $modelUri.$diff => array(
                        array('value' => $modelUri.$diff, 'type' => 'uri'),
                    ),
                    $modelUri.'p1' => array(
                        array('value' => $modelUri.$diff, 'type' => 'uri'),
                    ),
                    $modelUri.'p2' => array(
                        array('value' => $modelUri.$diff, 'type' => 'uri'),
                        array('value' => $modelUri.'old', 'type' => 'literal'),
                        array('value' => $modelUri.'o2', 'type' => 'uri'),
                    ),
                    'lang' => array(
                        array('value' => 'LANG', 'type' => 'literal', 'lang' => 'en'),
                        array('value' => 'LANG', 'type' => 'literal', 'lang' => 'de'),
                        array('value' => 'LANG', 'type' => 'literal', 'lang' => 'mn'),
                    ),
                    'type' => array(
                        array('value' => 'TYPE', 'type' => 'literal', 'datatype' => 'http://www.w3.org/2001/XMLSchema#string'),
                    ),
                ),
                $modelUri.'s3' => array(
                    $modelUri.$diff => array(
                        array('value' => $modelUri.'o3', 'type' => 'uri'),
                    ),
                ),
                $modelUri.'s4' => array(
                    $modelUri.'p4' => array(
                        array('value' => $modelUri.'o4', 'type' => 'uri'),
                    ),
                ),
            );
        }

        $model = $store->getNewModel($modelUri);
        $model->addMultipleStatements($graphs['new']);
        $query = Erfurt_Sparql_SimpleQuery::initWithString('SELECT ?s ?p ?o
                                                            FROM <' . $modelUri . '>
                                                            WHERE { ?s ?p ?o . }');
        $result = $store->sparqlQuery($query, array('result_format' => 'extended'));
        $expected = array();
        foreach ($result['results']['bindings'] as $statement) {
            $expected[$statement['s']['value']][$statement['p']['value']][] = $statement['o'];
        }
        $store->deleteModel($modelUri);

        $model = $store->getNewModel($modelUri);
        $model->addMultipleStatements($graphs['old']);

        $model->renameResource($modelUri.'old', $modelUri.'new');

        $query = Erfurt_Sparql_SimpleQuery::initWithString('SELECT ?s ?p ?o
                                                            FROM <' . $modelUri . '>
                                                            WHERE { ?s ?p ?o . }');
        $result = $store->sparqlQuery($query, array('result_format' => 'extended'));
        $got = array();
        foreach ($result['results']['bindings'] as $statement) {
            $got[$statement['s']['value']][$statement['p']['value']][] = $statement['o'];
        }

        $this->assertStatementsEqual($expected, $got, 'Graph after resource renaming');
    }

}

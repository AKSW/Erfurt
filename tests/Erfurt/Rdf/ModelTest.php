<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Rdf/Model.php';
require_once 'Erfurt/Rdf/StoreStub.php';

require_once 'Erfurt/Syntax/RdfParser.php';

class Erfurt_Rdf_ModelTest extends Erfurt_TestCase
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
    
    // ------------------------------------------------------------------------
    /*
    public function testGetModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        $model2 = new Erfurt_Rdf_Model('http://example.org/', 'http://example.org/resources/');
        
        $this->assertSame('http://example.org/', $model1->getModelIri());
        $this->assertSame('http://example.org/', $model2->getModelIri());
    }
    
    public function testGetBaseIriWithEmptyBaseReturnsModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        $model2 = new Erfurt_Rdf_Model('http://example.org/', 'http://example.org/resources/');
        
        $this->assertSame('http://example.org/',           $model1->getBaseIri());
        $this->assertSame('http://example.org/resources/', $model2->getBaseIri());
    }
    
    public function testToStringReturnsModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        
        $this->assertSame('http://example.org/', $model1->getModelIri());
        $this->assertSame('http://example.org/', (string) $model1);
    }
    
    public function testAddMultipleStatements()
    {        
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array();
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $model->addMultipleStatements($statements2);
        $this->assertEquals($statements2, $this->_storeStub->addMultipleStatements);
    }
    
    public function testDeleteMultipleStatements()
    {        
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array();
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $model->deleteMultipleStatements($statements2);
        $this->assertEquals($statements2, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceStatementsDiffer()
    {        
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array();
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($statements2, $this->_storeStub->addMultipleStatements);
        $this->assertEquals(array(), $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals(array(), $this->_storeStub->addMultipleStatements);
        $this->assertEquals($statements2, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDiffer()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1')
                )
            )
        );
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $s1only = array();
        $s2only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDifferInType()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'same', 'value' => 'same_object'), 
                    array('type' => 'literal', 'value' => 'object1'), 
                    array('type' => 'uri', 'value' => 'object2')
                )
            )
        );
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2'), 
                    array('type' => 'same', 'value' => 'same_object') 
                )
            )
        );
        
        $s1only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'object1'), 
                    array('type' => 'uri', 'value' => 'object2')
                )
            )
        );
        $s2only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'uri', 'value' => 'object1'), 
                    array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDifferInValue()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'same', 'value' => 'same_object'), 
                    array('type' => 'literal', 'value' => 'literal1'), 
                    array('type' => 'uri', 'value' => 'uri1')
                )
            )
        );
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'same', 'value' => 'same_object'), 
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'uri', 'value' => 'uri2')
                )
            )
        );
        
        $s1only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1'), 
                    array('type' => 'uri', 'value' => 'uri1')
                )
            )
        );
        $s2only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'uri', 'value' => 'uri2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }*/
    
    public function testUpdateWithMutualDifferenceObjectsDifferInDatatype()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'datatype' => 'datatype1'), 
                    array('type' => 'literal', 'value' => 'literal2', 'datatype' => 'datatype2'), 
                    array('type' => 'literal', 'value' => 'literal3'), 
                    array('type' => 'literal', 'value' => 'literal4', 'datatype' => 'datatype4')
                )
            )
        );
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'datatype' => 'datatype2'), 
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'literal', 'value' => 'literal3', 'datatype' => 'datatype3'), 
                    array('type' => 'literal', 'value' => 'literal4', 'datatype' => 'datatype4')
                )
            )
        );
        
        $s1only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'datatype' => 'datatype2'), 
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'literal', 'value' => 'literal3', 'datatype' => 'datatype3')
                )
            )
        );
        
        $s2only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'datatype' => 'datatype1'), 
                    array('type' => 'literal', 'value' => 'literal2', 'datatype' => 'datatype2'), 
                    array('type' => 'literal', 'value' => 'literal3')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);

        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDifferInLanguage()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'lang' => 'lang1'), 
                    array('type' => 'literal', 'value' => 'literal2', 'lang' => 'lang2'), 
                    array('type' => 'literal', 'value' => 'literal3'), 
                    array('type' => 'literal', 'value' => 'literal4', 'lang' => 'lang4')
                )
            )
        );
        $statements2 = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'lang' => 'lang2'), 
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'literal', 'value' => 'literal3', 'lang' => 'lang3'), 
                    array('type' => 'literal', 'value' => 'literal4', 'lang' => 'lang4')
                )
            )
        );
        
        $s1only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'lang' => 'lang2'), 
                    array('type' => 'literal', 'value' => 'literal2'), 
                    array('type' => 'literal', 'value' => 'literal3', 'lang' => 'lang3')
                )
            )
        );
        
        $s2only = array(
            'subject' => array(
                'predicate' => array(
                    array('type' => 'literal', 'value' => 'literal1', 'lang' => 'lang1'), 
                    array('type' => 'literal', 'value' => 'literal2', 'lang' => 'lang2'), 
                    array('type' => 'literal', 'value' => 'literal3')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);

        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceIssue436DifferentLanguages()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $modelUri = 'http://example.org/updateTest/';
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getNewModel($modelUri, false);
        
        $turtle1 = '@base <http://bis.ontowiki.net/> .
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
        
        $turtle2 = '@base <http://bis.ontowiki.net/> .
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

        $sparql = 'SELECT * FROM <http://example.org/updateTest/> WHERE {?s ?p ?o}';
        $result = $model->sparqlQuery($sparql);

        $this->assertEquals(12, count($result));
        
        $model->updateWithMutualDifference($statements1, $statements2);
        
        $result = $model->sparqlQuery($sparql);
        $this->assertEquals(10, count($result));
    }
    
    public function testGetDefaultPrefixesAndNamespaces()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
    
        $model = $store->getNewModel('http://example.org/namespaceTest/', '', 'owl', false);
        
        $default = array(
            'rdf'      => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#', 
            'rdfs'     => 'http://www.w3.org/2000/01/rdf-schema#', 
            'owl'      => 'http://www.w3.org/2002/07/owl#', 
            'xsd'      => 'http://www.w3.org/2001/XMLSchema#', 
            'sysont'   => 'http://ns.ontowiki.net/SysOnt/', 
            'dc'       => 'http://purl.org/dc/elements/1.1/', 
            'foaf'     => 'http://xmlns.com/foaf/0.1/', 
            'doap'     => 'http://usefulinc.com/ns/doap#', 
            'wordnet'  => 'http://xmlns.com/wordnet/1.6/', 
            'skos'     => 'http://www.w3.org/2004/02/skos/core#', 
            'sioc'     => 'http://rdfs.org/sioc/ns#', 
            'swrc'     => 'http://swrc.ontoware.org/ontology#', 
            'lcl'      => 'http://ns.aksw.org/e-learning/lcl/', 
            'geo'      => 'http://www.w3.org/2003/01/geo/wgs84_pos#', 
        );
        
        $prefixes = $model->getPrefixes();
        
        foreach ($default as $prefix=>$ns) {
            $this->assertArrayHasKey($prefix, $prefixes);
            $this->assertEquals($ns, $prefixes[$prefix]);
        }
        
        $namespaces = $model->getNamespaces();
        foreach ($default as $prefix=>$ns) {
            $this->assertArrayHasKey($ns, $namespaces);
            $this->assertEquals($prefix, $namespaces[$ns]);
        }
    }
    
    public function testAddAndGetAndDeletePrefix()
    {
        $this->markTestNeedsDatabase();
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
    
        $model = $store->getNewModel('http://example.org/namespaceTest/', '', 'owl', false);

        // add a test prefix to the model
        $model->addPrefix("test","http://testhausen/foo/bar/");

        // get prefixes from the model and test if added prefix exists
        $prefixes = $model->getPrefixes();
        $this->assertArrayHasKey("test", $prefixes);
        $this->assertEquals("http://testhausen/foo/bar/", $prefixes["test"]);

        // delete test prefix
        $model->deletePrefix("test");

        // check if it is deleted
        $prefixes = $model->getPrefixes();
        $this->assertFalse(array_key_exists("test", $prefixes));
        
        
        // add the test prefix to the model again
        // and delete it by namespace
        $model->addPrefix("test","http://testhausen/foo/bar/");
        $model->deleteNamespace("http://testhausen/foo/bar/");

        // check if it is deleted
        $prefixes = $model->getNamespaces();
        $this->assertFalse(array_key_exists("http://testhausen/foo/bar/", $prefixes));
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
}




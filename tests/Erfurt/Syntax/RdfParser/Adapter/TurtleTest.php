<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';

class Erfurt_Syntax_RdfParser_Adapter_TurtleTest extends Erfurt_TestCase
{
    const SYNTAX_TEST_DIR = 'resources/syntax/valid/';
    
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_Turtle
     * @access protected
     */
    protected $_object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object = new Erfurt_Syntax_RdfParser_Adapter_Turtle();   
    }
    
    
    public function testParseEmpty()
    {
        $data = '';
        
        $result = $this->_object->parseFromDataString($data);
        
        $this->assertEquals(0, count($result));
    }
    
    /**
     * @dataProvider providerTestParseFromFileName
     */
    public function testParseFromFileName($fileName)
    {   
        $fileHandle = fopen($fileName, 'r');
        $data = fread($fileHandle, filesize($fileName));
        fclose($fileHandle);
        
        try {
            $result = $this->_object->parseFromDataString($data);
            $this->assertTrue(is_array($result));
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    public function providerTestParseFromFileName()
    {
        $dataArray = array();
        
        if (is_readable(self::SYNTAX_TEST_DIR)) {
            $dirIterator = new DirectoryIterator(self::SYNTAX_TEST_DIR);
            
            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();
                    
                    if ((substr($fileName, -4) === '.ttl') && is_readable(self::SYNTAX_TEST_DIR . $fileName)) {
                        $dataArray[] = array((self::SYNTAX_TEST_DIR . $fileName));
                    }
                }
            }
        }
        
        return $dataArray;
    }
    
    public function testParseFromDataStringIssue421TurtleParserOnUpdateResturnsError()
    {
        $data = '<http://model.de#Class1> a <http://www.w3.org/2002/07/owl#Class> ;
        <http://www.w3.org/2000/01/rdf-schema#label> "classLabel"@de,
        "classLabel"@nl, "classLabel"@en ;
        <http://model.de#sort> "1" ;
        <http://www.w3.org/2000/01/rdf-schema#subClassOf> <http://model.de#Category> .';
        
        $result = $this->_object->parseFromDataString($data);

        $this->assertEquals(1, count($result));
        $this->assertEquals(4, count($result['http://model.de#Class1']));
    }
    
    public function testParseFromDataStringIssue446CorruptLanguageTags()
    {
        $turtle = '# Exported with the Erfurt API - http://aksw.org/Projects/Erfurt

        @base <http://bis.ontowiki.net/> .
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
                         ldap:telephoneNumber "+49 341 12-345678" ;
                         a swrc:FacultyMember ;
                         rdfs:label "Peter Pan ü 2 de"@de, "Peter Pan ü 2 nl"@nl", "Peter Pan ü nl"@nl" ;
                         foaf:firstName "Peter" ;
                         foaf:icqChatID "123-456-789" ;
                         foaf:mbox <mailto:peter.pan@informatik.uni-leipzig.de> ;
                         foaf:surname "Pan ü" .';
        
        try {
            $result = $this->_object->parseFromDataString($turtle);
            $this->fail('Parsing should fail, but did not fail.');
        } catch (Erfurt_Syntax_RdfParserException $e) {
            
        }
    }
    
    public function testParseFromDataStringIssue449LanguageIsResourceObject()
    {
        $turtle = '@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
        
                    <http://example.org/ttt/> rdfs:label "123"@de, "456"@en, "789"@nl .';

        $result = $this->_object->parseFromDataString($turtle);
        
        $lang1 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][0]['lang'];
        $lang2 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][1]['lang'];
        $lang3 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][2]['lang'];
        
        $this->assertFalse(is_object($lang1));
        $this->assertFalse(is_object($lang2));
        $this->assertFalse(is_object($lang3));
        $this->assertTrue(is_string($lang1));
        $this->assertTrue(is_string($lang2));
        $this->assertTrue(is_string($lang3));
    }
    
    public function testParseWithMailtoUriIssue477()
    {
        $turtle = '<http://example.org/1> <http://example.org/prop> <mailto:info@example.org> .';
        
        $result = $this->_object->parseFromDataString($turtle);

        $this->assertEquals(
            'mailto:info@example.org',
            $result['http://example.org/1']['http://example.org/prop'][0]['value']
        );
    }
    
    public function testParseWithDotAfterLanguageTagIssue536()
    {
        $turtle = '<http://example.org/1> <http://example.org/prop> "..."@nl.';
        
        $result = $this->_object->parseFromDataString($turtle);

        $this->assertEquals(
            '...',
            $result['http://example.org/1']['http://example.org/prop'][0]['value']
        );
        
        $this->assertEquals(
            'nl',
            $result['http://example.org/1']['http://example.org/prop'][0]['lang']
        );
    }
}

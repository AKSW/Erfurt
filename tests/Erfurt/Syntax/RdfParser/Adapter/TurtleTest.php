<?php
class Erfurt_Syntax_RdfParser_Adapter_TurtleTest extends Erfurt_TestCase
{
    const SYNTAX_TEST_DIR = 'valid/';
    
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
     * This test method requires rapper!
     *
     * @dataProvider providerTestParseFromFileName
     */
    public function testParseFromFileName($fileName)
    {   
        // This test method requires rapper!
        $rapperExistsResult = shell_exec('which rapper');
        if (null === $rapperExistsResult) {
            $this->markTestSkipped();
        }
        
        $fileHandle = fopen($fileName, 'r');
        $data = fread($fileHandle, filesize($fileName));
        fclose($fileHandle);
        
        $parserResult = null;
        try {
            $parserResult = $this->_object->parseFromDataString($data);
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
        
        $this->assertTrue(is_array($parserResult));
        
        // Check for .result file
        $resultFileName = str_replace('.ttl', '.result', $fileName);
        if (is_readable($resultFileName)) {
            $resultFileHandle = fopen($resultFileName, 'r');
            $resultData = fread($resultFileHandle, filesize($resultFileName));
            fclose($resultFileHandle);
            
            // Prepare parser result
            $parserResultTriplesArray = array();
            foreach ($parserResult as $s=>$pArray) {
                foreach ($pArray as $p=>$oArray) {
                    foreach ($oArray as $oSpec) {
                        $tripleString = '';
                        if (substr($s, 0, 2) === '_:') {
                            $tripleString .= $s;
                        } else {
                            $tripleString .= '<' . $s . '>';
                        }
                        $tripleString .= ' <' . $p . '> ';
                        
                        if ($oSpec['type'] === 'uri') {
                            $tripleString .= '<' . $oSpec['value']. '>';
                        } else if ($oSpec['type'] === 'bnode') {
                            $tripleString .= $oSpec['value'];
                        } else {
                            $tripleString .= '"""' . str_replace('"', '\"', $oSpec['value']) . '"""';
                            if (isset($oSpec['lang'])) {
                                $tripleString .= '@' . $oSpec['lang'];
                            } else if (isset($oSpec['datatype'])) {
                                $tripleString .= '^^<' . $oSpec['datatype'] . '>';
                            }
                        }
                        
                        $parserResultTriplesArray[] = $tripleString . ' . ';
                    }
                }
            }
            
            $resultArray = explode(PHP_EOL, trim($resultData));
            
            // Triple counts need to be equal
            $this->assertEquals(count($resultArray), count($parserResultTriplesArray));
            
            // Check for .base file for base URI
            $baseFileName = str_replace('.ttl', '.base', $fileName);
            $baseUri = 'file:' . $fileName;
            if (is_readable($baseFileName)) {
                $baseUri = trim(file_get_contents($baseFileName));
            }
            
            // Parse parser result (ntriples) with rapper iff avaiable and compare
            $parserResultTriplesString = implode(PHP_EOL, $parserResultTriplesArray);
            $tmpFileName = tempnam('/tmp', 'erfurt-test');
            $tmp = fopen($tmpFileName, 'w');
            fwrite($tmp, $parserResultTriplesString);
            fclose($tmp); 
            
            $cmd = "rapper -qi turtle -o turtle $tmpFileName | rapper -qi turtle -o ntriples -I $baseUri -";
            $output = array();
            $execResult = exec($cmd, $output);
            unlink($tmpFileName);
            
            $resultArray = array_unique($resultArray);
            sort($resultArray);
            $exptecedTriplesString = implode(PHP_EOL, $resultArray);
            
            $output = array_unique($output);
            sort($output);
            $actualTriplesString = implode(PHP_EOL, $output);
            
            $this->assertEquals(count($resultArray), count($output));
            $this->assertEquals($exptecedTriplesString, $actualTriplesString);
        }
    }
    
    public function providerTestParseFromFileName()
    {
        $dataArray = array();
        
        $dirName = realpath(dirname(dirname(dirname(__FILE__)))) . '/_files/' . self::SYNTAX_TEST_DIR;
        if (is_readable($dirName)) {
            $dirIterator = new DirectoryIterator($dirName);
            
            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();
                    
                    if ((substr($fileName, -4) === '.ttl') && is_readable($dirName . $fileName)) {
                        $dataArray[] = array(($dirName . $fileName));
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
    
    public function testParseWithTelUriIssue16()
    {
        $turtle = '<http://aksw.org/AlexDummy> <http://xmlns.com/foaf/0.1/phone> <tel:+49-341-97-32341> .';
        
        $result = $this->_object->parseFromDataString($turtle);

        $this->assertEquals(
            'tel:+49-341-97-32341',
            $result['http://aksw.org/AlexDummy']['http://xmlns.com/foaf/0.1/phone'][0]['value']
        );
    }
    
    public function testParseWithUrlEncodedUriIssue16()
    {
        $turtle = '<http://aksw.org/> <http://rdfs.org/ns/void#dataDump> <http://aksw.org/model/export/?m=http%3A%2F%2Faksw.org%2F&f=rdfxml> .';
        
        $result = $this->_object->parseFromDataString($turtle);

        $this->assertEquals(
            'http://aksw.org/model/export/?m=http%3A%2F%2Faksw.org%2F&f=rdfxml',
            $result['http://aksw.org/']['http://rdfs.org/ns/void#dataDump'][0]['value']
        );
    }
    
    public function testParseWithNoTrailingSlashIssue17()
    {
        $turtle = '@base <http://aksw.org> . <http://aksw.org/Projects/DL-Learner> <http://usefulinc.com/ns/doap#homepage> </tmp/dl-learner.org> .';
        
        $result = $this->_object->parseFromDataString($turtle);

        $this->assertEquals(
            'http://aksw.org/tmp/dl-learner.org',
            $result['http://aksw.org/Projects/DL-Learner']['http://usefulinc.com/ns/doap#homepage'][0]['value']
        );
    }
    
    public function testParseFromFileNameNoBaseUri()
    {
        $fileName = realpath(dirname(dirname(dirname(__FILE__)))) 
                  . '/_files/misc/test_no_base_uri.ttl';
                  
        $expectedUri = 'file://' 
                     . realpath(dirname(dirname(dirname(__FILE__)))) 
                     . '/_files/misc/ow_ext_community1.rq';
        
        $parserResult = null;
        try {
            $parserResult = $this->_object->parseFromFilename($fileName);
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
        
        $this->assertTrue(is_array($parserResult));
        
        foreach ($parserResult as $s=>$pArray) {
            foreach ($pArray as $p=>$oArray) {
                foreach ($oArray as $oSpec) {
                    if ($oSpec['type'] === 'uri') {
                        // Check for correct baseUri
                        $this->assertEquals($expectedUri, $oSpec['value']);
                    }
                }
            }
        }
    }
}

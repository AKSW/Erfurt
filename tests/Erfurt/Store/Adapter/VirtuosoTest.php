<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Store/Adapter/Virtuoso.php';

class Erfurt_Store_Adapter_VirtuosoTest extends Erfurt_TestCase
{
    public $fixture = null;
    private $_options = array(
        'dsn'      => 'VOS509', 
        'username' => 'dba', 
        'password' => 'dba'
    );
    
    public function setUp()
    {   
        // $this->markTestNeedsVirtuoso();
        $this->fixture = new Erfurt_Store_Adapter_Virtuoso($this->_options);
    }
    
    public function testInstantiation()
    {
        $this->assertSame('Erfurt_Store_Adapter_Virtuoso', get_class($this->fixture));
    }
    
    public function testListTables()
    {
        $this->assertEquals(true, in_array('RDF_QUAD', $this->fixture->listTables()));
    }
    
    public function testAddStatementWithUriObject()
    {
        $g = 'http://example.com/';
        $s = 'http://example.com/';
        $p = 'http://example.com/property1';
        $o = 'http:/example.com/resource1';
        
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o));
    }
    
    public function testAddStatementsWithLiteralObject()
    {
        $g = 'http://example.com/';
        $s = 'http://example.com/';
        $p = 'http://example.com/property1';
        
        require_once 'Erfurt/Store.php';
        $options = array('object_type' => Erfurt_Store::TYPE_LITERAL);
        
        // short literal
        $o = 'short literal';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing double quote
        $o = 'short "literal"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing escaped double quote
        $o = 'short \"literal\"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing single quote
        $o = "short 'literal'";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // short literal containing escaped single quote
        $o = "short \'literal\'";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 1
        $o = "long \n literal 1";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 2
        $o = "long
        literal 2";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // long literal 3
        $o = "long \r\n literal 2";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Unix path literal
        $o = '/usr/local/bin/virtuoso-t';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Windows path literal
        $o = "C:\\\\Programme\\\\Conficker\\\\FormatHardDrive.exe";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // Windows path literal
        $o = '"C:\\\\Program Files\\\\Conficker\\\\FormatHardDrive.exe"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        
        // boolean literal with numerical representation
        $o  = '1';
        $p2 = 'http://example.com/booleanProperty1';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p2, $o, array_merge(
            $options, 
            array('literal_datatype' => 'http://www.w3.org/2001/XMLSchema#boolean'))));
        
        // boolean literal with string representation
        $o  = 'true';
        $p2 = 'http://example.com/booleanProperty2';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p2, $o, array_merge(
            $options, 
            array('literal_datatype' => 'http://www.w3.org/2001/XMLSchema#boolean'))));
        
        
        // Vakantieland tests
        
        // vakantieland string 1 (unescaped)
        $o = 'verhuisd onder ? dak, nu "Apeldoorns Museum"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 1 (escaped) -- Virtuoso will remove escaping
        $o = 'verhuisd onder ? dak, nu \"Apeldoorns Museum\"';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 2
        $o = "per persoon: 113.45 &euro;<br/>CJP: 0 &euro;";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 3
        $o = "van.reekum";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 4
        $o = "http://www.apeldoorn.org/vanreekum/";
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
        
        // vakantieland string 5
        $o = '"In de Tinnen Wonderwereld" is niet langer wegens het overlijden van E. Spandauw (5-10-2000), de oprichter en uitbater van het museum. http://members.tripod.com/~tingieten/';
        $this->assertNotEquals(false, $this->fixture->addStatement($g, $s, $p, $o, $options));
    }
    
    public function testBuildLiteralString()
    {
        $value    = 'Literal';
        $datatype = 'http://www.w3.org/2001/XMLSchema#string';
        $expected = '"Literal"^^<http://www.w3.org/2001/XMLSchema#string>';
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, $datatype, null));
        
        $value    = "Literal \n with newline";
        $datatype = 'http://www.w3.org/2001/XMLSchema#string';
        $expected = "\"\"\"Literal \n with newline\"\"\"^^<http://www.w3.org/2001/XMLSchema#string>";
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, $datatype, null));
        
        $value    = 'Literal';
        $lang     = 'de';
        $expected = '"Literal"@de';
        $this->assertEquals($expected, $this->fixture->buildLiteralString($value, null, $lang));
    }
}


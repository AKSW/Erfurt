<?php
require_once 'test_base.php';
require_once 'Erfurt/Store/Adapter/Virtuoso.php';

class Erfurt_Store_Adapter_VirtuosoTest extends PHPUnit_Framework_TestCase
{
    public $fixture = null;
    private $_options = array(
        'dsn'      => 'VOS509', 
        'username' => 'dba', 
        'password' => 'dba'
    );
    
    public function setUp()
    {
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

    public function testEscapeLiterals()
    {
        $literal = "\n";
        $expected = '\\\n';
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal));

        $literal = "\r";
        $expected = '\\\r';
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal));

        $literal = "'";
        $expected = "\'";
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal));

        $literal = '"';
        $expected = '\"';
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal));

        $literal = '0';
        $expected = 'false';
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal, "http://www.w3.org/2001/XMLSchema#boolean"));

        $literal = '1';
        $expected = 'true';
        $this->assertEquals($expected ,$this->fixture->escapeLiteral($literal, "http://www.w3.org/2001/XMLSchema#boolean"));
    }

    public function testAddStatements()
    {
        $graphIri = "http://phpUnitTest.de/" ;
        $subject = 'http://phpUnitTest.de/LiteralTest';
        $predicate = 'http://phpUnitTest.de/escapeTheLiteral';
        $object = "Testing \n ";
        $options = array("object_type" => 1 );
        
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $graphIri = "http://phpUnitTest.de/" ;
        $subject = 'http://phpUnitTest.de/LiteralTest';
        $predicate = 'http://phpUnitTest.de/escapeTheLiteral';
        $object = "Testing \r ";
        $options = array("object_type" => 1 );
        
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

    }

    public function testAddMultipleStatements()
    {
        $graphIri = "http://phpUnitTest.de/" ;
        $subject = 'http://phpUnitTest.de/LiteralTest';
        $predicate = 'http://phpUnitTest.de/escapeTheLiteralString';
        $statementsArray[$subject][$predicate][0]['type'] = "literal" ;
        $statementsArray[$subject][$predicate][0]['datatype'] = "http://www.w3.org/2001/XMLSchema#string";
        $statementsArray[$subject][$predicate][0]['value'] = "Test \n \r ";
 
        $graphIri = "http://phpUnitTest.de/" ;
        $subject = 'http://phpUnitTest.de/LiteralTest';
        $predicate = 'http://phpUnitTest.de/escapeTheLiteralBoolean';
        $statementsArray[$subject][$predicate][0]['type'] = "literal" ;
        $statementsArray[$subject][$predicate][0]['datatype'] = "http://www.w3.org/2001/XMLSchema#boolean";
        $statementsArray[$subject][$predicate][0]['value'] = "0";
        $this->fixture->addMultipleStatements($graphIri, $statementsArray);

    }


}







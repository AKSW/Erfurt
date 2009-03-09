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


    public function testAddStatement()
    {
        $graphIri = "http://phpUnitTest.de/" ;
        $subject = 'http://phpUnitTest.de/LiteralTest';
        $predicate = 'http://phpUnitTest.de/escapeTheLiteral';

        $object = "Testing \n";
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = "Testing \r";
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = 'Testing "';
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = "Testing '";
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = 'Testing \"';
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = "Testing \"";
        $options = array("object_type" => 1 );
        $this->assertEquals(NULL , $this->fixture->addStatement($graphIri, $subject, $predicate, $object, $options));

        $object = "Testing \'";
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
        #$statementsArray[$subject][$predicate][0]['value'] = "-2015454240";
        #$statementsArray[$subject][$predicate][0]['value'] = "Museum";
        $statementsArray[$subject][$predicate][0]['value'] = 'verhuisd onder ? dak, nu "Apeldoorns Museum"';
        #$statementsArray[$subject][$predicate][0]['value'] = "per persoon: 113.45 &euro;<br/>CJP: 0 &euro;";

        #$subject = 'http://phpUnitTest.de/LiteralTest';
        #$predicate = 'http://phpUnitTest.de/escapeTheLiteralBoolean';
        #$statementsArray[$subject][$predicate][0]['type'] = "literal" ;
        #$statementsArray[$subject][$predicate][0]['datatype'] = "http://www.w3.org/2001/XMLSchema#boolean";
        #$statementsArray[$subject][$predicate][0]['value'] = "0";
        $this->fixture->addMultipleStatements($graphIri, $statementsArray);




#"""Museum"""
#"""verhuisd onder ? dak, nu \"Apeldoorns Museum\""""
#"""Een huis vol spraakmakende, vaak een beetje tegendraadse hedendaagse beeldende kunst. Wisselende exposities.""". 
#"""per persoon: 113.45 &euro;<br/>CJP: 0 &euro;"""
#"""Van Reekum Museum"""
#"""van.reekum"""
#"""http://www.apeldoorn.org/vanreekum/"""
#"""Van Reekum Museum"""@nl
#"""true"""^^<http://www.w3.org/2001/XMLSchema#boolean>


    }


}







<?php 

require_once 'Erfurt/TestCase.php';

class Erfurt_Store_Adapter_Virtuoso_ResultConverter_ExtendedTest extends Erfurt_TestCase
{
    protected $_fixture = null;
    
    public function setUp()
    {
        require_once 'Erfurt/Store/Adapter/Virtuoso/ResultConverter/Extended.php';
        $this->_fixture = new Erfurt_Store_Adapter_Virtuoso_ResultConverter_Extended();
    }
    
    /**
     * @expectedException Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception
     */
    public function testInvalid()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-invalid.rdf');
        $array = $this->_fixture->convert($contents);
    }
    
    /**
     * @expectedException Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception
     */
    public function testError()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-error.rdf');
        $array = $this->_fixture->convert($contents);
    }
    
    public function testTitleResultEmpty()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-empty.rdf');
        $converted = $this->_fixture->convert($contents);
        
        $this->assertArrayHasKey('head', $converted);
        $this->assertArrayHasKey('vars', $converted['head']);
        $this->assertEquals(0, count($converted['head']['vars']));
        
        $this->assertArrayHasKey('results', $converted);
        $this->assertArrayHasKey('bindings', $converted['results']);
        
        $this->assertEquals(0, count($converted['results']['bindings']));
    }
    
    public function testTitleResult1()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-result1.rdf');
        $converted = $this->_fixture->convert($contents);
        
        $this->assertArrayHasKey('head', $converted);
        $this->assertArrayHasKey('vars', $converted['head']);
        $this->assertTrue(in_array('__resource', $converted['head']['vars']));
        $this->assertTrue(in_array('property', $converted['head']['vars']));
        $this->assertTrue(in_array('value', $converted['head']['vars']));
        
        $this->assertArrayHasKey('results', $converted);
        $this->assertArrayHasKey('bindings', $converted['results']);
        
        $this->assertEquals(1, count($converted['results']['bindings']));
        
        reset($converted['results']['bindings']);
        $row = current($converted['results']['bindings']);
        $this->assertEquals(3, count($row));
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://localhost/OntoWiki/Config/'), 
            $row['__resource']
        );
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://www.w3.org/2000/01/rdf-schema#label'), 
            $row['property']
        );
        
        $this->assertEquals(
            array('type' => 'literal', 'value' => 'OntoWiki System Configuration'), 
            $row['value']
        );
    }
    
    public function testTitleResult2()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-result2.rdf');
        $converted = $this->_fixture->convert($contents);
        
        $this->assertArrayHasKey('head', $converted);
        $this->assertArrayHasKey('vars', $converted['head']);
        $this->assertTrue(in_array('s', $converted['head']['vars']));
        $this->assertTrue(in_array('p', $converted['head']['vars']));
        $this->assertTrue(in_array('o', $converted['head']['vars']));
        
        $this->assertArrayHasKey('results', $converted);
        $this->assertArrayHasKey('bindings', $converted['results']);
        
        $this->assertEquals(1, count($converted['results']['bindings']));
        
        reset($converted['results']['bindings']);
        $row = current($converted['results']['bindings']);
        $this->assertEquals(3, count($row));
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://localhost/OntoWiki/phil/Cordoba'), 
            $row['s']
        );
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://www.w3.org/2000/01/rdf-schema#label'), 
            $row['p']
        );
        
        $this->assertEquals(
            array('type' => 'literal', 'value' => 'Córdoba', 'xml:lang' => 'es'), 
            $row['o']
        );
    }
    
    public function testTitleResult3()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-result3.rdf');
        $converted = $this->_fixture->convert($contents);
        
        $this->assertArrayHasKey('head', $converted);
        $this->assertArrayHasKey('vars', $converted['head']);
        $this->assertTrue(in_array('s', $converted['head']['vars']));
        $this->assertTrue(in_array('p', $converted['head']['vars']));
        $this->assertTrue(in_array('o', $converted['head']['vars']));
        
        $this->assertArrayHasKey('results', $converted);
        $this->assertArrayHasKey('bindings', $converted['results']);
        
        $this->assertEquals(1, count($converted['results']['bindings']));
        
        reset($converted['results']['bindings']);
        $row = current($converted['results']['bindings']);
        $this->assertEquals(3, count($row));
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://localhost/OntoWiki/phil/'), 
            $row['s']
        );
        
        $this->assertEquals(
            array('type' => 'uri', 'value' => 'http://www.w3.org/2000/01/rdf-schema#comment'), 
            $row['p']
        );
        
        $expected = array(
            'type' => 'typed-literal', 
            'datatype' => 'http://www.w3.org/2001/XMLSchema#string', 
            'value' => 'AKSW demo knowledge base about philosophers. It demonstrates various OntoWiki features such as arbitrary object hierarchies, geoinformation reasoning, semantic plug-ins adn blank node usage.'
        );
        
        $this->assertEquals($expected, $row['o']);
    }
    
    public function testTitleResult4()
    {
        $contents = file_get_contents('resources/virtuoso/sparql-result4.rdf');
        $converted = $this->_fixture->convert($contents);
        
        $this->assertArrayHasKey('head', $converted);
        $this->assertArrayHasKey('vars', $converted['head']);
        $this->assertTrue(in_array('s', $converted['head']['vars']));
        $this->assertTrue(in_array('p', $converted['head']['vars']));
        $this->assertTrue(in_array('o', $converted['head']['vars']));
        
        $this->assertArrayHasKey('results', $converted);
        $this->assertArrayHasKey('bindings', $converted['results']);
        
        $this->assertEquals(145, count($converted['results']['bindings']));
        
        reset($converted['results']['bindings']);
        $row = current($converted['results']['bindings']);
        $this->assertEquals(3, count($row));
    }
}


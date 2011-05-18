<?php 

require_once 'Erfurt/TestCase.php';

class Erfurt_NamespacesTest extends Erfurt_TestCase
{
    const TEST_GRAPH = 'http://example.com/stub/';
    
    protected $_fixture = null;
    protected $_modelStub = null;
    
    public function setUp()
    {        
        $this->_reserved = array(
            'reserved1', 
            'reserved2'
        );
        
        $this->_standard = array(
            'rdf'  => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#', 
            'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#', 
            'owl'  => 'http://www.w3.org/2002/07/owl#', 
            'xsd'  => 'http://www.w3.org/2001/XMLSchema#', 
            'foaf' => 'http://xmlns.com/foaf/0.1/', 
            'sioc' => 'http://rdfs.org/sioc/ns#'
        );
        
        $namespaceOptions = array(
            'reserved_names'    => $this->_reserved, 
            'standard_prefixes' => $this->_standard
        );
        
        require_once 'Erfurt/Namespaces.php';
        $this->_fixture = new Erfurt_Namespaces($namespaceOptions);
        
        require_once 'Erfurt/Rdf/ModelStub.php';
        $this->_modelStub = new Erfurt_Rdf_ModelStub(self::TEST_GRAPH);
    }
    
    public function testAddNamespacePrefix()
    {        
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/foo', 'foo');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $expected = array('value' => 'foo=http://example.com/foo', 'type' => 'literal');
        
        $this->assertEquals(true, in_array($expected, $options));
    }
    
    /**
     * @expectedException Erfurt_Namespaces_Exception
     */
    public function testAddNamespacePrefixReserved()
    {
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/reserved1', 'reserved1');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $unexpected = array('value' => 'reserved1=http://example.com/reserved1', 'type' => 'literal');
        
        $this->assertEquals(false, in_array($unexpected, $options));
    }
    
    /**
     * @expectedException Erfurt_Namespaces_Exception
     */
    public function testAddNamespacePrefixInvalid()
    {
        $this->_fixture->addNamespacePrefix($this->_modelStub, "http://example.com/\nfoo", 'foo');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $unexpected = array('value' => "foo=http://example.com/\nfoo", 'type' => 'literal');
        
        $this->assertEquals(false, in_array($unexpected, $options));
    }
    
    /**
     * @expectedException Erfurt_Namespaces_Exception
     */
    public function testAddNamespacePrefixExisting()
    {
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/foo', 'foo');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $expected = array('value' => 'foo=http://example.com/foo', 'type' => 'literal');
        
        $this->assertEquals(true, in_array($expected, $options));
        
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/foo2', 'foo');
    }
    
    public function testDeleteNamespacePrefix()
    {
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/abc', 'abc');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $expected = array('value' => 'abc=http://example.com/abc', 'type' => 'literal');
        $this->assertEquals(true, in_array($expected, $options));
        
        $this->_fixture->deleteNamespacePrefix($this->_modelStub, 'abc');
        
        $options = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $this->assertEquals(false, in_array($expected, $options));
    }
    
    public function testGetNamespacePrefixExisting()
    {
        $this->_fixture->addNamespacePrefix($this->_modelStub, 'http://example.com/bar', 'bar');
        
        $options  = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $expected = array('value' => 'bar=http://example.com/bar', 'type' => 'literal');
        $this->assertEquals(true, in_array($expected, $options));
        
        
        $prefix = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://example.com/bar');
        $this->assertEquals('bar', $prefix);
    }
    
    public function testGetNamespacePrefixSynthesized()
    {        
        $options = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $this->assertEquals(true, empty($options));
        
        $prefix1 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://example.com/test1');
        $this->assertEquals('ns0', $prefix1);
        
        $prefix2 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://example.com/test2');
        $this->assertEquals('ns1', $prefix2);
        
        $prefix3 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://example.com/test1');
        $this->assertEquals('ns0', $prefix3);
    }
    
    public function testGetNamespacePrefixStandard()
    {
        $options = $this->_modelStub->getOption(Erfurt_Namespaces::PREFIX_PREDICATE);
        $this->assertEquals(true, empty($options));
        
        $prefix1 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
        $this->assertEquals('rdf', $prefix1);
        
        $prefix2 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://www.w3.org/2001/XMLSchema#');
        $this->assertEquals('xsd', $prefix2);
        
        $prefix3 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://xmlns.com/foaf/0.1/');
        $this->assertEquals('foaf', $prefix3);
        
        $prefix4 = $this->_fixture->getNamespacePrefix($this->_modelStub, 'http://rdfs.org/sioc/ns#');
        $this->assertEquals('sioc', $prefix4);
    }
}
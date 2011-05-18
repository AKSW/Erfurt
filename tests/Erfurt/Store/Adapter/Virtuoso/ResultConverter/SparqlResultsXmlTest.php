<?php 

require_once 'Erfurt/TestCase.php';

class Erfurt_Store_Adapter_Virtuoso_ResultConverter_SparqlResultsXmlTest extends Erfurt_TestCase
{
    protected $_fixture = null;
    
    public function setUp()
    {
        require_once 'Erfurt/Store/Adapter/Virtuoso/ResultConverter/SparqlResultsXml.php';
        $this->_fixture = new Erfurt_Store_Adapter_Virtuoso_ResultConverter_SparqlResultsXml();
    }
    
    /**
     * @expectedException Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception
     */
    public function testInvalidFormatHead()
    {
       $invalid1 = array('head' => null, 'results' => array('bindings' => array()));
       $results1 = $this->_fixture->convert($invalid1);
    }
    
    /**
     * @expectedException Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception
     */
    public function testInvalidFormatResults()
    {       
       $invalid2 = array('head' => array('vars' => array()), 'results' => null);
       $results2 = $this->_fixture->convert($invalid2);
    }
    
    public function testSimple()
    {
        $extended = array(
            'head' => array('vars' => array('1', '2', '3')), 
            'results' => array('bindings' => array(
                array(
                    '1' => array('type' => 'uri', 'value' => 'http://example.com/1'), 
                    '2' => array('type' => 'literal', 'value' => 'ttt'), 
                    '3' => array('type' => 'literal', 'value' => 'ttt', 'datatype' => 'http://www.w3.org/2001/XMLSchema#string')
                ), 
                array(
                    '1' => array('type' => 'uri', 'value' => 'http://example.com/1'), 
                    '2' => array('type' => 'literal', 'value' => 'ttt'), 
                    '3' => array('type' => 'literal', 'value' => 'äää', 'xml:lang' => 'de')
                )
            ))
        );
        
        $expected = <<<EOT
<?xml version="1.0"?>
<sparql xmlns="http://www.w3.org/2005/sparql-results#">
  <head>
    <variable name="1"/>
    <variable name="2"/>
    <variable name="3"/>
  </head>
  <results>
    <result>
      <binding name="1"><uri>http://example.com/1</uri></binding>
      <binding name="2"><literal>ttt</literal></binding>
      <binding name="3"><literal datatype="http://www.w3.org/2001/XMLSchema#string">ttt</literal></binding>
    </result>
    <result>
      <binding name="1"><uri>http://example.com/1</uri></binding>
      <binding name="2"><literal>ttt</literal></binding>
      <binding name="3"><literal xml:lang="de">äää</literal></binding>
    </result>
  </results>
</sparql>
EOT;
        $actual = $this->_fixture->convert($extended);
        
        $this->assertSame(
            preg_replace('/\s/', '', $expected), 
            preg_replace('/\s/', '', $actual));
    }
}
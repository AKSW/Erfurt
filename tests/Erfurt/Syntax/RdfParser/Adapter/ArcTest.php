<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';

class Erfurt_Syntax_RdfParser_Adapter_ArcTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
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
        $this->_object = new Erfurt_Syntax_RdfParser_Adapter_Arc('rdfxml');    
    }
    
    public function testParseFromUrlToStore()
    {
// TODO model has to be available
$this->markTestIncomplete('Not implemented yet.');return;        

        $url = 'http://ontowiki.googlecode.com/svn/trunk/models/Conferences/conferences.rdf';
        $graphUri = 'http://3ba.se/conferences/3/';
        
        
        $this->_object->parseFromUrlToStore($url, $graphUri);
    }
}

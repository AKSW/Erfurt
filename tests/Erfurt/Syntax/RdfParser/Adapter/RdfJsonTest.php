<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';

class Erfurt_Syntax_RdfParser_Adapter_RdfJsonTest extends Erfurt_TestCase
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
        $this->_object = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();    
    }
    
    public function testParseFromUrl()
    {
// TODO model has to be available
        $this->markTestIncomplete('Not implemented yet.');
        
        $url = 'http://localhost/ontowiki_1_0/ontowiki/src/model/export/f/rdfjson?m=http%3A%2F%2F3ba.se%2Fconferences%2F';
        $graphUri = 'http://3ba.se/conferences/3/';
        
        
        $this->_object->parseFromUrl($url);
    }
}

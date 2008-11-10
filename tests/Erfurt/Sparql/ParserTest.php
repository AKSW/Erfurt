<?php
require_once 'test_base.php';
require_once 'Erfurt/Sparql/Parser.php';

class Erfurt_Sparql_ParserTest extends PHPUnit_Framework_TestCase
{
    protected $_parser = null;
    
    public function setUp()
    {
        $this->_parser = new Erfurt_Sparql_Parser();
    }
    
    // ------------------------------------------------------------------------
    
    public function testTokenize()
    {
        $tokens = array(
            'ABC', 'abc', '0123456789', '(', ')', '[', ']', '"', '"', "'", "'", '{', '}', 'x', 'x', 'x', 
            '?$', '.', ',', '#', '#', '#', ';', '#'
        );
        
        $tokenString = "ABC abc 0123456789 \n () \t [] \"\" '' {} x\nx\tx ?$ ., # \r # #;#";
        
        $this->assertEquals($tokens, Erfurt_Sparql_Parser::tokenize($tokenString));
    }
    
    public function testUncomment()
    {
        $queryString = '# bla
                        ## bla bla
                        ### bla bla bla';
                         
        $this->assertEquals('', trim(Erfurt_Sparql_Parser::uncomment($queryString)));
    }
}




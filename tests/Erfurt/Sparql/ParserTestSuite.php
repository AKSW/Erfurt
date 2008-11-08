<?php
require_once 'test_base.php';
require_once 'Erfurt/Sparql/ParserParseTest.php';
require_once 'Erfurt/Sparql/ParserTest.php';

class Erfurt_Sparql_ParserTestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Sparql_ParserTestSuite('Sparql Parser Tests');
        
        $suite->addTest(new Erfurt_Sparql_ParserParseTest());
        $suite->addTestSuite('Erfurt_Sparql_ParserTest');
        
        return $suite;
    }
}

<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXmlTest.php';

class Erfurt_Syntax_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Syntax_TestSuite('Erfurt syntax package tests');
        
        $suite->addTestSuite('Erfurt_Syntax_RdfParser_Adapter_RdfXmlTest');
        
        return $suite;
    }
}

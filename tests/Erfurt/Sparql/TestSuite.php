<?php
require_once 'Erfurt/Sparql/ParserTest.php';
require_once 'Erfurt/Sparql/SimpleQueryTest.php';
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer/ExtendedTest.php';

class Erfurt_Sparql_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Sparql_TestSuite('Erfurt sparql package tests');
        
        $suite->addTestSuite('Erfurt_Sparql_ParserTest');
        $suite->addTestSuite('Erfurt_Sparql_SimpleQueryTest');
        
        $suite->addTestSuite('Erfurt_Sparql_EngineDb_ResultRenderer_ExtendedTest');
        
        return $suite;
    }
}

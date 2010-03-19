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
        $suite->addTestSuite('Erfurt_Sparql_Query2Test');
        $suite->addTestSuite('Erfurt_Sparql_Query2_VarTest');
        $suite->addTestSuite('Erfurt_Sparql_Query2_ContainerHelperTest');
        $suite->addTestSuite('Erfurt_Sparql_Query2_ElementHelperTest');
        $suite->addTestSuite('Erfurt_Sparql_Query2_TripleTest');
        $suite->addTestSuite('Erfurt_Sparql_Query2_RDFLiteralTest');
        $suite->addTestSuite('Erfurt_Sparql_Query2_GroupGraphPatternTest');

        $suite->addTestSuite('Erfurt_Sparql_EngineDb_ResultRenderer_ExtendedTest');
        
        return $suite;
    }
}

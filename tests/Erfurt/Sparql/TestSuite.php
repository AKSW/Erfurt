<?php
require_once 'test_base.php';
require_once 'Erfurt/Sparql/ParserTestSuite.php';


class Erfurt_Sparql_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Sparql_TestSuite('Erfurt sparql package tests');
        
        $suite->addTestSuite('Erfurt_Sparql_ParserTestSuite');
        
        return $suite;
    }
}

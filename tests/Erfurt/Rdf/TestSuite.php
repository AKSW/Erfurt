<?php
require_once 'Erfurt/Rdf/ModelTest.php';
require_once 'Erfurt/Rdf/LiteralTest.php';
require_once 'Erfurt/Rdf/ResourceTest.php';


class Erfurt_Rdf_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Rdf_TestSuite('Erfurt Rdf package tests');
        
        $suite->addTestSuite('Erfurt_Rdf_ModelTest');
        $suite->addtestSuite('Erfurt_Rdf_LiteralTest');
        $suite->addTestSuite('Erfurt_Rdf_ResourceTest');
        
        return $suite;
    }
}

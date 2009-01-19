<?php
require_once 'test_base.php';
require_once 'Erfurt/Rdf/ModelTest.php';


class Erfurt_Rdf_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Rdf_TestSuite('Erfurt Rdf package tests');
        
        $suite->addTestSuite('Erfurt_Rdf_ModelTest');
        
        return $suite;
    }
}

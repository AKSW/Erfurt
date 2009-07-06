<?php
require_once 'Erfurt/Owl/ModelTest.php';

class Erfurt_Owl_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Owl_TestSuite('Erfurt Owl package tests');
        
        $suite->addTestSuite('Erfurt_Owl_ModelTest');
        
        return $suite;
    }
}

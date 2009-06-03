<?php
require_once 'Erfurt/VersioningTest.php';

class Erfurt_Versioning_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Versioning_TestSuite('Erfurt versioning package tests');
        
        $suite->addTestSuite('Erfurt_VersioningTest');
        
        return $suite;
    }
}

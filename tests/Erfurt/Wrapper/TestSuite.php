<?php
require_once 'Erfurt/Wrapper/RegistryTest.php';
require_once 'Erfurt/Wrapper/ManagerTest.php';

class Erfurt_Wrapper_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Wrapper_TestSuite('Erfurt wrapper package tests');
        
        $suite->addTestSuite('Erfurt_Wrapper_RegistryTest');
        $suite->addTestSuite('Erfurt_Wrapper_ManagerTest');
        
        return $suite;
    }
}

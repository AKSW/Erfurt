<?php
require_once 'Erfurt/Auth/Adapter/RdfTest.php';
//require_once 'Erfurt/Auth/Adapter/OpenIdTest.php';

class Erfurt_Auth_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Auth_TestSuite('Erfurt auth package tests');
        
        $suite->addTestSuite('Erfurt_Auth_Adapter_RdfTest');
        //$suite->addTestSuite('Erfurt_Auth_Adapter_OpenIdTest');
        
        return $suite;
    }
}

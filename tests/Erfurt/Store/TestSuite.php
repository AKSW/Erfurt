<?php
require_once 'Erfurt/Store/Adapter/VirtuosoTest.php';
require_once 'Erfurt/StoreTest.php';

class Erfurt_Store_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Store_TestSuite('Erfurt store package tests');
        
        $suite->addTestSuite('Erfurt_Store_Adapter_VirtuosoTest');
        $suite->addTestSuite('Erfurt_Store_Adapter_Virtuoso_ResultConverter_ExtendedTest');
        $suite->addTestSuite('Erfurt_StoreTest');
        
        return $suite;
    }
}

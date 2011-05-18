<?php
require_once 'Erfurt/AppTest.php';
require_once 'Erfurt/Auth/TestSuite.php';
require_once 'Erfurt/Rdf/TestSuite.php';
require_once 'Erfurt/Owl/TestSuite.php';
require_once 'Erfurt/Sparql/TestSuite.php';
require_once 'Erfurt/Store/TestSuite.php';
require_once 'Erfurt/Syntax/TestSuite.php';
require_once 'Erfurt/Versioning/TestSuite.php';
require_once 'Erfurt/Wrapper/TestSuite.php';

class Erfurt_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_TestSuite('Erfurt Tests');
        
        $suite->addTestSuite('Erfurt_AppTest');
        $suite->addTestSuite('Erfurt_Auth_TestSuite');
        $suite->addTestSuite('Erfurt_NamespacesTest');
        $suite->addTestSuite('Erfurt_Rdf_TestSuite');
        $suite->addTestSuite('Erfurt_Owl_TestSuite');
        $suite->addTestSuite('Erfurt_Sparql_TestSuite');
        $suite->addTestSuite('Erfurt_Store_TestSuite');
        $suite->addTestSuite('Erfurt_Syntax_TestSuite');
        $suite->addTestSuite('Erfurt_Versioning_TestSuite');
        $suite->addTestSuite('Erfurt_Wrapper_TestSuite');
        
        return $suite;
    }
}

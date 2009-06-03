<?php
require_once 'Erfurt/Syntax/RdfParserTest.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJsonTest.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXmlTest.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/TurtleTest.php';

require_once 'Erfurt/Syntax/RdfSerializerTest.php';
require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJsonTest.php';

class Erfurt_Syntax_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new Erfurt_Syntax_TestSuite('Erfurt syntax package tests');
        
        // Parser tests
        $suite->addTestSuite('Erfurt_Syntax_RdfParserTest');
        $suite->addTestSuite('Erfurt_Syntax_RdfParser_Adapter_RdfJsonTest');
        $suite->addTestSuite('Erfurt_Syntax_RdfParser_Adapter_RdfXmlTest');
        $suite->addTestSuite('Erfurt_Syntax_RdfParser_Adapter_TurtleTest');
        
        // Serializer tests
        $suite->addTestSuite('Erfurt_Syntax_RdfSerializerTest');
        $suite->addTestSuite('Erfurt_Syntax_RdfSerializer_Adapter_RdfJsonTest');
        
        return $suite;
    }
}

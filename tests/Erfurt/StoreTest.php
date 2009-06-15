<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Store.php';

class Erfurt_StoreTest extends Erfurt_TestCase
{    
    public function testExistence()
    {
        $this->assertTrue(class_exists('Erfurt_Store'));
    }
    
    public function testImportRdfFrom303Url()
    {
        $this->markTestNeedsDatabase();
        
        $url = 'http://ns.softwiki.de/req/';
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $store->getNewModel($url, false);
        
        try {
            $store->importRdf($url, $url, 'auto', Erfurt_Syntax_RdfParser::LOCATOR_URL, false);
        } catch (Erfurt_Exception $e) {
            $store->deleteModel($url, false);
            $this->fail($e->getMessage());
        }
        
        $store->deleteModel($url, false);
    }
}




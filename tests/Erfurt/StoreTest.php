<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Store.php';

class Erfurt_StoreTest extends Erfurt_TestCase
{    
    public function testExistence()
    {
        $this->assertTrue(class_exists('Erfurt_Store'));
    }
}




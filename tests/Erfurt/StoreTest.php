<?php
require_once 'test_base.php';
require_once 'Erfurt/Store.php';

class Erfurt_StoreTest extends PHPUnit_Framework_TestCase
{
    private $_fixture;
        
    public function testExistence()
    {
        $this->assertSame(true, class_exists('Erfurt_Store'));
    }
}




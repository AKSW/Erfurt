<?php
require_once 'test_base.php';
require_once 'Erfurt/Store/Adapter/Virtuoso.php';

class Erfurt_Store_Adapter_VirtuosoTest extends PHPUnit_Framework_TestCase
{
    public $fixture = null;
    private $_options = array(
        'dsn'      => 'VOS505', 
        'username' => 'dba', 
        'password' => 'dba'
    );
    
    public function setUp()
    {
        $this->fixture = new Erfurt_Store_Adapter_Virtuoso($this->_options);
    }
    
    public function testInstantiation()
    {
        $this->assertSame('Erfurt_Store_Adapter_Virtuoso', get_class($this->fixture));
    }
}




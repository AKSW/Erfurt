<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Wrapper/Manager.php';
require_once 'Erfurt/Wrapper/Registry.php';

class Erfurt_Wrapper_ManagerTest extends Erfurt_TestCase
{
    protected $_manager = null;
    
    protected function setUp()
    {
        $this->_manager = new Erfurt_Wrapper_Manager();
    } 
    
    public function testAddWrapperPathWithNotExistingPath()
    {
        // Should not fail...
        $this->_manager->addWrapperPath('/this/path/does/not/exist');
    }
    
    public function testAddWrapperPathWithExistingPath()
    {        
        $this->_manager->addWrapperPath('resources/wrapper');
        
        $registry = Erfurt_Wrapper_Registry::getInstance();
        $activeWrapper = $registry->listActiveWrapper();
        
        $this->assertEquals(1, count($activeWrapper));
        $this->assertEquals('enabled', $activeWrapper[0]);
    }
}

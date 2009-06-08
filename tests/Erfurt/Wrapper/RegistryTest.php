<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Wrapper/Manager.php';
require_once 'Erfurt/Wrapper/Registry.php';

class Erfurt_Wrapper_RegistryTest extends Erfurt_TestCase
{
    protected $_registry = null;
    
    protected function setUp()
    {
        $this->_registry = Erfurt_Wrapper_Registry::getInstance();
    }
    
    protected function tearDown()
    {
        Erfurt_Wrapper_Registry::reset();
        
        parent::tearDown();
    }
    
    public function testGetInstance()
    {
        $instance = Erfurt_Wrapper_Registry::getInstance();
        
        $this->assertTrue($instance instanceof Erfurt_Wrapper_Registry);
    }
    
    public function testGetWrapperInstanceWillFail()
    {
        try {
            $this->_registry->getWrapperInstance('doesnotexist');
        
            $this->fail();
        } catch (Erfurt_Wrapper_Exception $e) {
            
        }
    }
    
    public function testGetWrapperInstanceWillSucceed()
    {
        $manager = new Erfurt_Wrapper_Manager();
        $manager->addWrapperPath('resources/wrapper');
        
        try {
            $this->_registry->getWrapperInstance('enabled');
        } catch (Erfurt_Wrapper_Exception $e) {
            $this->fail();
        }
    }
    
    public function testListActiveWrapperEmpty()
    {
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertTrue(empty($result));
    }
    
    public function testListActiveWrapper()
    {
        $manager = new Erfurt_Wrapper_Manager();
        $manager->addWrapperPath('resources/wrapper');
        
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertEquals(1, count($result));
        $this->assertEquals('enabled', $result[0]);
    }
    
    public function testRegister()
    {
        $this->_registry->register('dummy', array());
        
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertEquals(1, count($result));
        $this->assertEquals('dummy', $result[0]);
    }
    
    public function testRegisterAlreadyRegistered()
    {
        $this->_registry->register('dummy', array());
        
        try {
            $this->_registry->register('dummy', array());
            
            $this->fail();
        } catch (Erfurt_Wrapper_Exception $e) {
            
        }
    }   
}

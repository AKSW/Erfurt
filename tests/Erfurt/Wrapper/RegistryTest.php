<?php
class Erfurt_Wrapper_RegistryTest extends Erfurt_TestCase
{
    protected $_registry = null;
    
    protected $_resourcesPath = null;
    
    protected function setUp()
    {
        $this->_registry = Erfurt_Wrapper_Registry::getInstance();
        
        $this->_resourcesPath = realpath(dirname(__FILE__)) . '/_files/';
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
        $manager->addWrapperPath($this->_resourcesPath);
        
        try {
            $this->_registry->getWrapperInstance('enabled');
        } catch (Erfurt_Wrapper_Exception $e) {
            $this->fail();
        }
    }
    
    public function testListActiveWrapperEqualsDefaultWrappers()
    {
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertEquals(2, count($result));
        $this->assertTrue(in_array('linkeddata', $result));
        $this->assertTrue(in_array('rdfa', $result));
    }
    
    public function testListActiveWrapper()
    {
        $manager = new Erfurt_Wrapper_Manager();
        $manager->addWrapperPath($this->_resourcesPath);
        
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertEquals(3, count($result));
        $this->assertTrue(in_array('linkeddata', $result));
        $this->assertTrue(in_array('rdfa', $result));
        $this->assertTrue(in_array('enabled', $result));
    }
    
    public function testRegister()
    {
        $this->_registry->register('dummy', array());
        
        $result = $this->_registry->listActiveWrapper();
        
        $this->assertEquals(3, count($result));
        $this->assertTrue(in_array('linkeddata', $result));
        $this->assertTrue(in_array('rdfa', $result));
        $this->assertTrue(in_array('dummy', $result));
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

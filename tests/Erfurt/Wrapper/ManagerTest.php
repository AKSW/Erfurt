<?php
class Erfurt_Wrapper_ManagerTest extends Erfurt_TestCase
{
    protected $_manager = null;
    
    protected $_resourcesPath = null;
    
    protected function setUp()
    {
        $this->_manager = new Erfurt_Wrapper_Manager();
        
        $this->_resourcesPath = realpath(dirname(__FILE__)) . '/_files/';
    } 
    
    protected function tearDown()
    {
        Erfurt_Wrapper_Registry::reset();
    }
    
    public function testAddWrapperPathWithNotExistingPath()
    {
        // Should not fail...
        $this->_manager->addWrapperPath('/this/path/does/not/exist');
    }
    
    public function testAddWrapperPathWithExistingPath()
    {        
        $this->_manager->addWrapperPath($this->_resourcesPath);
        
        $registry = Erfurt_Wrapper_Registry::getInstance();
        $activeWrapper = $registry->listActiveWrapper();
        
        $this->assertEquals(3, count($activeWrapper));
        $this->assertTrue(in_array('linkeddata', $activeWrapper));
        $this->assertTrue(in_array('rdfa', $activeWrapper));
        $this->assertTrue(in_array('enabled', $activeWrapper));
    }
    
    public function testWrapperInstantiation()
    {        
        $this->_manager->addWrapperPath($this->_resourcesPath);
        
        $registry = Erfurt_Wrapper_Registry::getInstance();

        $ldw = $registry->getWrapperInstance('linkeddata');
        $this->assertInstanceOf('Erfurt_Wrapper_LinkeddataWrapper', $ldw);
        $rdfaw = $registry->getWrapperInstance('rdfa');
        $this->assertInstanceOf('Erfurt_Wrapper_RdfaWrapper', $rdfaw);
        $ew = $registry->getWrapperInstance('enabled');
        $this->assertInstanceOf('EnabledWrapper', $ew);
    }
}

<?php
require_once 'test_base.php';
require_once 'Erfurt/Rdf/Model.php';
require_once 'Erfurt/Rdf/StoreStub.php';

class Erfurt_Rdf_ModelTest extends PHPUnit_Framework_TestCase
{
    protected $_storeStub = null;
    
    public function setUp()
    {
        $this->_storeStub = new Erfurt_Rdf_StoreStub();
    }
    
    protected function _getMockedModel()
    {        
        $model = $this->getMock('Erfurt_Rdf_Model', // original class name
            array('getStore'),                      // method to mock
            array('http://example.org/')            // constructor params
        );
        $model->expects($this->any())
              ->method('getStore')
              ->will($this->returnValue($this->_storeStub));
        
        return $model;
    }
    
    // ------------------------------------------------------------------------
    
    public function testGetModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        $model2 = new Erfurt_Rdf_Model('http://example.org/', 'http://example.org/resources/');
        
        $this->assertSame('http://example.org/', $model1->getModelIri());
        $this->assertSame('http://example.org/', $model2->getModelIri());
    }
    
    public function testGetBaseIriWithEmptyBaseReturnsModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        $model2 = new Erfurt_Rdf_Model('http://example.org/', 'http://example.org/resources/');
        
        $this->assertSame('http://example.org/',           $model1->getBaseIri());
        $this->assertSame('http://example.org/resources/', $model2->getBaseIri());
    }
    
    public function testToStringReturnsModelIri()
    {
        $model1 = new Erfurt_Rdf_Model('http://example.org/');
        
        $this->assertSame('http://example.org/', $model1->getModelIri());
        $this->assertSame('http://example.org/', (string) $model1);
    }
    
    public function testAddMultipleStatements()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = new stdClass();
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $model->addMultipleStatements($statements2);
        $this->assertEquals($statements2, $this->_storeStub->addMultipleStatements);
    }
    
    public function testDeleteMultipleStatements()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = new stdClass();
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $model->deleteMultipleStatements($statements2);
        $this->assertEquals($statements2, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceStatementsDiffer()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = new stdClass();
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($statements2, $this->_storeStub->addMultipleStatements);
        $this->assertEquals(new stdClass, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals(new stdClass, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($statements2, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDiffer()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1')
                )
            )
        );
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        $s1only = (object) array();
        $s2only = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDifferInType()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'same', 'value' => 'same_object'), 
                    (object) array('type' => 'literal', 'value' => 'object1'), 
                    (object) array('type' => 'uri', 'value' => 'object2')
                )
            )
        );
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2'), 
                    (object) array('type' => 'same', 'value' => 'same_object') 
                )
            )
        );
        
        $s1only = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'literal', 'value' => 'object1'), 
                    (object) array('type' => 'uri', 'value' => 'object2')
                )
            )
        );
        $s2only = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'uri', 'value' => 'object1'), 
                    (object) array('type' => 'literal', 'value' => 'object2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }
    
    public function testUpdateWithMutualDifferenceObjectsDifferInValue()
    {
        $model = $this->_getMockedModel();
        
        // prepare data
        $statements1 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'same', 'value' => 'same_object'), 
                    (object) array('type' => 'literal', 'value' => 'literal1'), 
                    (object) array('type' => 'uri', 'value' => 'uri1')
                )
            )
        );
        $statements2 = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'same', 'value' => 'same_object'), 
                    (object) array('type' => 'literal', 'value' => 'literal2'), 
                    (object) array('type' => 'uri', 'value' => 'uri2')
                )
            )
        );
        
        $s1only = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'literal', 'value' => 'literal1'), 
                    (object) array('type' => 'uri', 'value' => 'uri1')
                )
            )
        );
        $s2only = (object) array(
            'subject' => (object) array(
                'predicate' => array(
                    (object) array('type' => 'literal', 'value' => 'literal2'), 
                    (object) array('type' => 'uri', 'value' => 'uri2')
                )
            )
        );
        
        // test 1
        $model->updateWithMutualDifference($statements1, $statements2);
        $this->assertEquals($s2only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s1only, $this->_storeStub->deleteMultipleStatements);
        
        // test 2
        $model->updateWithMutualDifference($statements2, $statements1);
        $this->assertEquals($s1only, $this->_storeStub->addMultipleStatements);
        $this->assertEquals($s2only, $this->_storeStub->deleteMultipleStatements);
    }
}




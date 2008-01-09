<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id: $
 */
class Erfurt_Rdfs_Property_DefaultTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	
	public static function suite() {
		
		return new PHPUnit_Framework_TestSuite('Erfurt_Rdfs_Property_DefaultTest');
	}
	
	public function setUp() {
		
		$this->store = $this->store = Zend_Registry::get('store');
		
		if ($this->store->modelExists('http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/')) {
			$this->store->deleteModel('http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/');	
		}
	
	
		$this->model = $this->store->getNewModel(
						'http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/');
						
		$this->model->load(ERFURT_TEST_BASE.'Erfurt/Rdfs/Property/DefaultTest.rdf');
	}
	
	public function testAddDomain() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testAddRange() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testAddSubProperty() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testCountDistinctPropertyValues() {
		
		$property = $this->model->propertyF(
							'http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/testProp2', false);
		
		$count = $property->countDistinctPropertyValues(null, false);
		$this->assertEquals(6, $count);
		
		$count = $property->countDistinctPropertyValues(null, true);
		$this->assertEquals(2, $count);
			
		$count = $property->countDistinctPropertyValues('notExistingClass', false);
		$this->assertEquals(2, $count);
		
		$count = $property->countDistinctPropertyValues('notExistingClass', true);
		$this->assertEquals(1, $count);
	}

	public function testGetDomain() {
		
		$property = $this->model->propertyF(
							'http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/testProp1', false);
		
		$domain = $property->getDomain();
		
		#print_r($domain);
		$this->assertTrue(($domain instanceof RDFSClass));
		$this->assertEquals('http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/testDomain1',
		 					$domain->getURI());
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testGetRange() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testListDistinctPropertyValues() {
	
		$property = $this->model->propertyF(
							'http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Property_DefaultTest/0.1/testProp2', false);
		
		$values = $property->listDistinctPropertyValues(null, false);
		$this->assertEquals(6, count($values));
		
		$values = $property->listDistinctPropertyValues(null, true);
		$this->assertEquals(2, count($values));
		
		$values = $property->listDistinctPropertyValues('notExistingClass', false);
		$this->assertEquals(2, count($values));
		
		$values = $property->listDistinctPropertyValues('notExistingClass', true);
		$this->assertEquals(1, count($values));
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testListDomain() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testListRange() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testListSubProperties() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testListSuperProperties() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testRemoveDomain() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testRemoveRange() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testSetDomain() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testSetRange() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testSetSubProperties() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testSetSuperProperties() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
}

?>

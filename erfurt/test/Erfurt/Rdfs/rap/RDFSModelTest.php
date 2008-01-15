<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
class RDFSModelTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	
	public static function suite() {
		
		return new PHPUnit_Framework_TestSuite('RDFSModelTest');
	}
	
	public function setUp() {
		
		$this->store = new Erfurt_Store_Adapter_Rap('mysqli', 'localhost', 'erfurt_testbed', 'powl', 'powl');
		$this->model = $this->store->getNewModel('http://ns.ontowiki.net/unittest/RDFSModelTest/0.1/');
		// $this->instance->load('RDFSModelTest.rdf');
		
	}
	
	public function tearDown() {
		
		$this->store->deleteModel('http://ns.ontowiki.net/unittest/RDFSModelTest/0.1/');
	}
	
	public function testUpdate() {
		
		$res1 	= new Resource('http://example.org/resource1');
		$res2 	= new Resource('http://example.org/resource2');
		$bn1 	= new BlankNode('bn1');
		$bn2	= new BlankNode('bn2');
		$lit1	= new Literal('Literal1');
		$lit2	= new Literal('Literal1', 'en');
		$lit3	= new Literal('Literal1', 'en', 'http://www.w3.org/2001/XMLSchema#string');
		
		$rdf_type = new Resource(EF_RDF_TYPE);
		$rdfs_label = new Resource(EF_RDFS_LABEL);
		
		$stm1 = new Statement($res1, $rdf_type, $res2);
		$stm2 = new Statement($bn1, $rdf_type, $bn2);
		$stm3 = new Statement($res1, $rdfs_label, $lit1);
		$stm4 = new Statement($res1, $rdfs_label, $lit2);
		$stm5 = new Statement($res1, $rdfs_label, $lit3);
		
		// test case memModel1 is empty, memModel2 contains data -> should add all statements from memModel2
		$memModel1 = new MemModel();
		$memModel2 = new MemModel();
		$memModel2->add($stm1);
		$memModel2->add($stm2);
		$memModel2->add($stm3);
		$memModel2->add($stm4);
		$memModel2->add($stm5);
		
		$this->assertTrue($memModel1->isEmpty());
		$this->assertEquals(5, $memModel2->size());
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(5,$this->model->size());
		
		// test case first model contains the data, second is empty (just switch the params) -> should delete all 
		// statements
		$this->model->update($memModel2, $memModel1);
		$this->assertTrue($this->model->isEmpty());
		
		// now test the more difficult cases
		$memModel2 = new MemModel();
		$memModel1->add($stm1);
		$memModel2->add($stm1);
		$this->model->update($memModel1, $memModel2);
		// should be empty, because, memModel1 equals memModel2
		$this->assertTrue($this->model->isEmpty());
		
		$memModel2->add($stm2);
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(1, $this->model->size());
		
		$memModel1->add($stm2);
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(1, $this->model->size()); 
		
		$memModel2->remove($stm2);
		$this->model->update($memModel1, $memModel2);
		$this->assertTrue($this->model->isEmpty());
		
		// especially test for literals that differ only in datatype and language
		$memModel1 = new MemModel();
		$memModel2 = new MemModel();
		$memModel2->add($stm3);
		$memModel2->add($stm4);
		$memModel2->add($stm5);
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(3, $this->model->size()); 
		
		$memModel2 = new MemModel();
		$memModel1->add($stm3);
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(2, $this->model->size());
		
		$memModel2->add($stm3);
		$memModel1->add($stm4);
		$this->model->update($memModel1, $memModel2);
		$this->assertEquals(1, $this->model->size());
		
		$memModel2->add($stm4);
		$memModel1->add($stm5);
		$this->model->update($memModel1, $memModel2);
		$this->assertTrue($this->model->isEmpty());
	}
}
?>

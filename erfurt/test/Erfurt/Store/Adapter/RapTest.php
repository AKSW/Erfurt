<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id: $
 */
class Erfurt_Store_Adapter_RapTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	
	public static function suite() {
		
		return new PHPUnit_Framework_TestSuite('Erfurt_Store_Adapter_RapTest');
	}
	
	public function setUp() {
		
		$this->store = $this->store = Zend_Registry::get('store');
		
		if ($this->store->modelExists(
				'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/')) {
			$this->store->deleteModel(
				'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/');	
		}
		
		$this->model = $this->store->getNewModel(
				'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/');
	}
	
	public function testExecuteFindDefiningModels() {
			
		$s = new Resource(
			'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/res1');
			
		$p = new Resource(
			'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/res2');
				
		$o = new Resource(
			'http://ns.ontowiki.net/unittest/Erfurt_Store_Adapter_RapTest/testExecuteDefiningModels/res3');
		
		$this->model->add(new Statement($s, $p, $o));
			
		$defModels = $this->store->executeFindDefiningModels($s, $p, $o);
		
		$this->assertEquals($this->model->modelURI, $defModels[0]);
	}
}
?>

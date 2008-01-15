<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id: $
 */
class Erfurt_Rdfs_Resource_DefaultTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	
	public static function suite() {
		
		return new PHPUnit_Framework_TestSuite('Erfurt_Rdfs_Resource_DefaultTest');
	}
	
	public function setUp() {
		
		$this->store = $this->store = Zend_Registry::get('store');
		
		if ($this->store->modelExists('http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Resource_DefaultTest/0.1/')) {
			$this->store->deleteModel('http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Resource_DefaultTest/0.1/');	
		}
	
	
		$this->model = $this->store->getNewModel(
						'http://ns.ontowiki.net/unittest/Erfurt_Rdfs_Resource_DefaultTest/0.1/');
	}
	
	public function testGetQualifiedName() {
		
		// blank nodes should have the bnode id returned
		$b = $this->model->resourceF(EF_BNODE_PREFIX.'0');
		$this->assertEquals(EF_BNODE_PREFIX.'0', $b->getQualifiedName());
		
		// for the moment the full uri should be returned in case no prefix exists
		$r = $this->model->resourceF('http://test.de/type');
		$this->assertEquals('http://test.de/type', $r->getQualifiedName());
		
		// add a prefix for the rdf ns
		$r = $this->model->resourceF(EF_RDF_TYPE);
		$this->model->addNamespace('RDF', EF_RDF_NS);
		$this->assertEquals('RDF:type', $r->getQualifiedName());
	}
}

?>

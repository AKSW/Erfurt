<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id: $
 */
class Erfurt_App_DefaultTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	
	public static function suite() {
		
		return new PHPUnit_Framework_TestSuite('Erfurt_App_DefaultTest');
	}
	
	public function setUp() {
		
		$this->store = $this->store = Zend_Registry::get('store');
		
	}
	
	public function testGetStore() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	
}

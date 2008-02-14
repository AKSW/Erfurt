<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../config.php';
}

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id: CacheTest.php 1744 2007-12-19 13:16:42Z p_frischmuth $
 */
class Erfurt_Cache_FrontendTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	protected $cache;
	
	public static function suite() {
		
		return new PHPUnit_Framework_testSuite('Erfurt_Cache_FrontendTest');
	}
	
	public function setUp() {
		
		$this->store = Zend_Registry::get('store');
		
		if ($this->store->modelExists('http://ns.ontowiki.net/unittest/Erfurt_CacheTest/0.1/')) {
			$this->store->deleteModel('http://ns.ontowiki.net/unittest/Erfurt_CacheTest/0.1/');	
		}
		
		$this->model = $this->store->getNewModel('http://ns.ontowiki.net/unittest/Erfurt_CacheTest/0.1/');
		#$this->model->load('DefaultTest.rdf');
		$this->cache = new Erfurt_Cache_Frontend($this->store);
		
		// start clean
		$this->cache->emptySecondLevel($this->model);
	}
	
	public function testSaveAndLoadFirstLevelWithSimpleString() {
		
		// test caching of a string containing a lot of different chars (without resource, args and triggers)
		$cacheVal = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789<>.,;:-_#*+ß?=)(/&%$§\"!^'`´";
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithSimpleString',
			array()));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithSimpleString', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithSimpleString', array());
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadSecondLevelWithSimpleString() {
		
		// test caching of a string containing a lot of different chars (without resource, args and triggers)
		$cacheVal = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789<>.,;:-_#*+ß?=)(/&%$§\"!^'`´";
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithSimpleString',
			array()));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithSimpleString', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithSimpleString', array());
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadFirstLevelWithLongString() {
		
		// test caching of a large string
		$cacheVal = '';
		$cachedVal = null;
		for ($i=0; $i<1000000; ++$i) {
			$cacheVal .= 't';
		}
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithLongString',
			array()));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithLongString', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithLongString', array());
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadSecondLevelWithLongString() {
		
		// test caching of a large string
		$cacheVal = '';
		$cachedVal = null;
		for ($i=0; $i<1000000; ++$i) {
			$cacheVal .= 't';
		}
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithLongString',
			array()));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithLongString', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithLongString', array());
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadFirstLevelWithMemModel() {
		
		// test caching of a MemModel object
		$cacheVal = new MemModel();
		$cachedVal = null;
		for($i=0; $i<1000; ++$i) {
			$cacheVal->add(new Statement(new Resource('http://example.com/test1'.$i), 
								 		 new Resource('http://example.com/test2'.$i),
										 new Resource('http://example.com/test3'.$i)));
		}
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithMemModel',
			array()));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithMemModel', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithMemModel', array());
		$this->assertTrue($cacheVal->equals($cachedVal));
	}
	
	public function testSaveAndLoadSecondLevelWithMemModel() {
		
		// test caching of a MemModel object
		$cacheVal = new MemModel();
		$cachedVal = null;
		for($i=0; $i<1000; ++$i) {
			$cacheVal->add(new Statement(new Resource('http://example.com/test1'.$i), 
								 		 new Resource('http://example.com/test2'.$i),
										 new Resource('http://example.com/test3'.$i)));
		}
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithMemModel',
			array()));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithMemModel', array(), null,
			$cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithMemModel', array());
		$this->assertTrue($cacheVal->equals($cachedVal));
	}
	
	public function testSaveAndLoadFirstLevelWithArgumentsAndFloatingPointValue() {
		
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = 128.453;
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithArgumentsAndFloatingPointValue', $args));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithArgumentsAndFloatingPointValue',
			$args, null, $cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithArgumentsAndFloatingPointValue', $args);
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadSecondLevelWithArgumentsAndFloatingPointValue() {
		
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = 128.453;
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithArgumentsAndFloatingPointValue', $args));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithArgumentsAndFloatingPointValue',
			$args, null, $cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithArgumentsAndFloatingPointValue', $args);
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadFirstLevelWithArgumentsAndResourceAndBooleanValue() {
		
		// test caching with arguments and a resource as cache initiator and boolean value as value
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$r = new Resource('http://example.com/test1');
		$cacheVal = true;
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithArgumentsAndResourceAndBooleanValue', $args), $r);
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithArgumentsAndResourceAndBooleanValue',
			$args, $r, $cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithArgumentsAndResourceAndBooleanValue', $args, $r);
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadSecondLevelWithArgumentsAndResourceAndBooleanValue() {
		
		// test caching with arguments and a resource as cache initiator and boolean value as value
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$r = new Resource('http://example.com/test1');
		$cacheVal = true;
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithArgumentsAndResourceAndBooleanValue', $args), $r);
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithArgumentsAndResourceAndBooleanValue',
			$args, $r, $cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithArgumentsAndResourceAndBooleanValue', $args, $r);
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadFirstLevelWithTriggersAndBooleanValue() {
		
		// test caching with triggers 
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = false;
		$cachedVal = null;
		$triggers = array('http://example.com/test1', 'http://example.com/test2', 'http://example.com/test3');
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithTriggersAndBooleanValue', $args));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithTriggersAndBooleanValue',
			$args, null, $cacheVal, $triggers);
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithTriggersAndBooleanValue', $args);
		$this->assertEquals($cacheVal, $cachedVal);	
	}
	
	public function testSaveAndLoadSecondLevelWithTriggersAndBooleanValue() {
		
		// test caching with triggers 
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = false;
		$cachedVal = null;
		$triggers = array('http://example.com/test1', 'http://example.com/test2', 'http://example.com/test3');
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithTriggersAndBooleanValue', $args));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithTriggersAndBooleanValue',
			$args, null, $cacheVal, $triggers);
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithTriggersAndBooleanValue', $args);
		$this->assertEquals($cacheVal, $cachedVal);	
	}
	
	public function testSaveAndLoadFirstLevelWithStringArray() {
		
		$cacheVal = array('string1', 'string2', 'http://example.com/string3');
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithStringArray'));
		
		$this->cache->saveFirstLevel($this->model, 'testSaveAndLoadFirstLevelWithStringArray',
			array(), null, $cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testSaveAndLoadFirstLevelWithStringArray');
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testSaveAndLoadSecondLevelWithStringArray() {
		
		$cacheVal = array('string1', 'string2', 'http://example.com/string3');
		$cachedVal = null;
		
		// cache should be empty
		$this->assertFalse($this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithStringArray'));
		
		$this->cache->saveSecondLevel($this->model, 'testSaveAndLoadSecondLevelWithStringArray',
			array(), null, $cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testSaveAndLoadSecondLevelWithStringArray');
		$this->assertEquals($cacheVal, $cachedVal);
	}
	
	public function testExpireFirstLevelWithSingleMatch() {
		
		$cacheVal = array('string1', 'string2', 'http://example.com/string3');
		$cachedVal = null;
		
		$this->cache->saveFirstLevel($this->model, 'testExpireFirstLevelWithSingleMatch',
			array(), null, $cacheVal);
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testExpireFirstLevelWithSingleMatch');	
		$this->assertEquals($cacheVal, $cachedVal);
		
		// expire the cache value
		$this->cache->expireFirstLevel($this->model);
		
		$cachedVal = $this->cache->loadFirstLevel($this->model,
			'testExpireFirstLevelWithSingleMatch');
		$this->assertFalse($cachedVal);
	}
	
	public function testExpireSecondLevelWithSingleMatch() {
		
		$cacheVal = array('string1', 'string2', 'http://example.com/string3');
		$cachedVal = null;
		
		$this->cache->saveSecondLevel($this->model, 'testExpireSecondLevelWithSingleMatch',
			array(), null, $cacheVal);
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testExpireSecondLevelWithSingleMatch');	
		$this->assertEquals($cacheVal, $cachedVal);
		
		// expire the cache value
		$this->cache->expireSecondLevel($this->model);
		
		$cachedVal = $this->cache->loadSecondLevel($this->model,
			'testExpireSecondLevelWithSingleMatch');
		$this->assertFalse($cachedVal);
	}
}
?>

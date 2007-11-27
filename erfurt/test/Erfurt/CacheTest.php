<?php
require_once 'config.php';

/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
class Erfurt_CacheTest extends PHPUnit_Framework_TestCase {
	
	protected $store;
	protected $model;
	protected $cache;
	
	public function setUp() {
		
		$this->store = new Erfurt_Store_Adapter_Rap('mysqli', 'localhost', 'erfurt_testbed', 'powl', 'powl');
		$this->model = $this->store->getNewModel('http://ns.ontowiki.net/unittest/Erfurt_CacheTest/0.1/');
		$this->cache = new Erfurt_Cache($this->store);
	}
	
	public function tearDown() {
		
		$this->store->deleteModel('http://ns.ontowiki.net/unittest/Erfurt_CacheTest/0.1/');
	}
	
	public function testSaveAndLoad() {
		
		// test caching of a string containing a lot of different chars (without resource, args and triggers)
		$cacheVal = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789<>.,;:-_#*+ß?=)(/&%$§\"!^'`´";
		$cachedVal = null;
		$this->cache->save($this->model, 'testFunction', array(), null, $cacheVal);
		$cachedVal = $this->cache->load($this->model, 'testFunction', array());
		$this->assertEquals($cacheVal, $cachedVal);
		$this->cache->expire($this->model, null);
		
		
		// test caching of a large string
		$cacheVal = '';
		$cachedVal = null;
		for ($i=0; $i<1000000; ++$i) {
			$cacheVal .= 't';
		}
		$this->cache->save($this->model, 'testFunction2', array(), null, $cacheVal);
		$cachedVal = $this->cache->load($this->model, 'testFunction2', array());
		$this->assertEquals($cacheVal, $cachedVal);
		$this->cache->expire($this->model, null);
		
		// test caching of a MemModel object
		$cacheVal = new MemModel();
		for($i=0; $i<10000; ++$i) {
			$cacheVal->add(new Statement(new Resource('http://example.com/test1'.$i), 
										 new Resource('http://example.com/test2'.$i),
										 new Resource('http://example.com/test3'.$i)));
		}
		$this->cache->save($this->model, 'testFunction3', array(), null, $cacheVal);
		$cachedVal = $this->cache->load($this->model, 'testFunction3', array());
		$this->assertTrue($cacheVal->equals($cachedVal));
		$this->cache->expire($this->model, null);
		
		// test caching with arguments and floating point cache value
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = 128.453;
		$cachedVal = null;
		$this->cache->save($this->model, 'testFunction4', $args, null, $cacheVal);
		$cachedVal = $this->cache->load($this->model, 'testFunction4', $args);
		$this->assertEquals($cacheVal, $cachedVal);
		$this->cache->expire($this->model, null);
		
		// test caching with arguments and a resource as cache initiator and boolean value as value
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = true;
		$cachedVal = null;
		$this->cache->save($this->model, 'testFunction5', $args, new Resource('http://example.com/test1'), $cacheVal);
		$cachedVal = $this->cache->load($this->model, 'testFunction5', $args, new Resource('http://example.com/test1'));
		$this->assertTrue($cachedVal);
		$this->cache->expire($this->model, null);
		
		// test caching with triggers 
		$args = array(1, 'test', null, true, false, new Resource('http://example.com/test1'));
		$cacheVal = false;
		$cachedVal = null;
		$triggers = array('http://example.com/test1', 'http://example.com/test2', 'http://example.com/test3');
		$this->cache->save($this->model, 'testFunction6', $args, new Resource('http://example.com/test1'), $cacheVal,
		 					$triggers);
		$cachedVal = $this->cache->load($this->model, 'testFunction6', $args, new Resource('http://example.com/test1'));
		$this->assertFalse($cachedVal);
		$this->cache->expire($this->model, new Statement(new Resource('http://example.com/test1'.$i), 
									 					 new Resource('http://example.com/test2'.$i),
									 					 new Resource('http://example.com/test3'.$i)));

// TODO first level only tests
	}
	
	public function testExpire() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
	
	public function testExpireFunction() {
		
		throw new PHPUnit_Framework_IncompleteTestError();
	}
}
?>

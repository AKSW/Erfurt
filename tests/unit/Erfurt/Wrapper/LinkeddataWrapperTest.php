<?php

class LinkeddataWrapperTest extends Erfurt_TestCase
{
    private $_wrapper = null;
    private $_dataDir = null;

    public function setUp()
    {
        $this->markTestNeedsTestConfig();

        $this->_wrapper = new Erfurt_Wrapper_LinkeddataWrapper();

        $this->_dataDir = realpath(dirname(__FILE__)) . '/_files/data/';
    }

    public function testGetDescription()
    {
        $this->assertTrue(is_string($this->_wrapper->getDescription()));
    }

    public function testGetName()
    {
        $this->assertTrue(is_string($this->_wrapper->getName()));
    }

    public function testIsHandledTrueHttp()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledTrueHttps()
    {
        $r = new Erfurt_Rdf_Resource('https://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseNonHttp()
    {
        $r = new Erfurt_Rdf_Resource('mailto:me@example.org');

        $this->assertFalse($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledTrueConfigHandleAll()
    {
        $config = new Zend_Config(array('handle' => array(
            'mode' => 'all',
            'exception' => array('http://example.org/ttt')
        )), true);
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseConfigHandleAllException()
    {
        $config = new Zend_Config(array('handle' => array(
            'mode' => 'all',
            'exception' => array('http://example.org/test')
        )), true);
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertFalse($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledTrueConfigHandleNoneException()
    {
        $config = new Zend_Config(array('handle' => array(
            'mode' => 'none',
            'exception' => array('http://example.org/test')
        )), true);
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseConfigHandleNone()
    {
        $config = new Zend_Config(array('handle' => array(
            'mode' => 'none',
            'exception' => array('http://example.org/ttt')
        )), true);
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertFalse($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledTrueWithLocator()
    {
        $r = new Erfurt_Rdf_Resource('mailto:me@example.org');
        $r->setLocator('http://mailto2url/meAtExample.org');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseWithLocator()
    {
        $r = new Erfurt_Rdf_Resource('mailto:me@example.org');
        $r->setLocator('mailto:anotherMe@example.org');

        $this->assertFalse($this->_wrapper->isHandled($r, null));
    }

    public function testIsAvailableTrueRdfXmlResource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource1');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'application/rdf+xml'),
            file_get_contents($this->_dataDir . 'testResource1.rdf')
        ));

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueRdfN3Resource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource2');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->addResponse(new Zend_Http_Response(
            404,
            array(),
            null
        ));
        $adapter->addResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'text/rdf+n3'),
            file_get_contents($this->_dataDir . 'testResource2.ttl')
        ));

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueRdfHTMLResource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource3');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            404,
            array(),
            null
        ));
        $adapter->addResponse(new Zend_Http_Response(
            404,
            array(),
            null
        ));
        $adapter->addResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'text/html'),
            file_get_contents($this->_dataDir . 'testResource3.html')
        ));
        $adapter->addResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'application/rdf+xml'),
            file_get_contents($this->_dataDir . 'testResource3.rdf')
        ));

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableFalse()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource4');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            404,
            array(),
            null
        ));

        $this->assertFalse($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueWithLocator()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource1');
        $r->setLocator = 'http://example.org/testResource1.rdf';

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'application/rdf+xml'),
            file_get_contents($this->_dataDir . 'testResource1.rdf')
        ));

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueWithLocatorDataDoesNotContainRequestedResource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource5');
        $r->setLocator = 'http://example.org/testResource1';

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
                200,
                array('Content-type' => 'application/rdf+xml'),
                file_get_contents($this->_dataDir . 'testResource1.rdf')
            ));

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testRunAvailableData()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource1');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            200,
            array('Content-type' => 'application/rdf+xml'),
            file_get_contents($this->_dataDir . 'testResource1.rdf')
        ));

        $result = $this->_wrapper->run($r, null);
        $this->assertEquals(array(
                'http://example.org/testResource1' => array(
                    'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' => array(array(
                        'type' => 'uri',
                        'value' => 'http://xmlns.com/foaf/0.1/Person'
                    )),
                    'http://xmlns.com/foaf/0.1/nick' => array(array(
                        'type' => 'literal',
                        'value' => 'testResource1'
                    ))
                )
            ),
            $result['add']
        );

        $this->assertEquals(array(
                'http://www.w3.org/1999/02/22-rdf-syntax-ns#' => 'rdf',
                'http://xmlns.com/foaf/0.1/' => 'foaf'
            ),
            $result['ns']
        );

        $this->assertEquals(
            array(Erfurt_Wrapper::NO_MODIFICATIONS, Erfurt_Wrapper::RESULT_HAS_ADD, Erfurt_Wrapper::RESULT_HAS_NS),
            $result['status_codes']
        );
    }

    public function testRunNoData()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource5');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(new Zend_Http_Response(
            404,
            array(),
            null
        ));

        $this->assertFalse($this->_wrapper->run($r, null));
    }
}

<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class RdfaWrapperTest extends Erfurt_TestCase
{
    private $_wrapper = null;
    private $_dataDir = null;

    public function setUp()
    {
        $this->markTestNeedsTestConfig();

        $this->_wrapper = new Erfurt_Wrapper_RdfaWrapper();

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
        $config = new Zend_Config(
            array(
                'handle' => array(
                    'mode' => 'all',
                    'exception' => array('http://example.org/ttt')
                )
            ),
            true
        );
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseConfigHandleAllException()
    {
        $config = new Zend_Config(
            array(
                'handle' => array(
                    'mode' => 'all',
                    'exception' => array('http://example.org/test')
                )
            ),
            true
        );
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertFalse($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledTrueConfigHandleNoneException()
    {
        $config = new Zend_Config(
            array(
                'handle' => array(
                    'mode' => 'none',
                    'exception' => array('http://example.org/test')
                )
            ),
            true
        );
        $this->_wrapper->init($config);

        $r = new Erfurt_Rdf_Resource('http://example.org/test');

        $this->assertTrue($this->_wrapper->isHandled($r, null));
    }

    public function testIsHandledFalseConfigHandleNone()
    {
        $config = new Zend_Config(
            array(
                'handle' => array(
                    'mode' => 'none',
                    'exception' => array('http://example.org/ttt')
                )
            ),
            true
        );
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

    public function testIsAvailableTrueHTMLResource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/rdfaTestResource1');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);

        $adapter->setResponse(
            new Zend_Http_Response(
                200,
                array('Content-type' => 'text/html'),
                file_get_contents($this->_dataDir . 'rdfaTestResource1.html')
            )
        );

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableFalse()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource4');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(
            new Zend_Http_Response(
                404,
                array(),
                null
            )
        );

        $this->assertFalse($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueWithLocator()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource1');
        $r->setLocator = 'http://example.org/rdfaTestResource1.html';

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(
            new Zend_Http_Response(
                200,
                array('Content-type' => 'text/html'),
                file_get_contents($this->_dataDir . 'rdfaTestResource1.html')
            )
        );

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testIsAvailableTrueWithLocatorDataDoesNotContainRequestedResource()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource5');
        $r->setLocator = 'http://example.org/rdfaTestResource1';

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(
            new Zend_Http_Response(
                200,
                array('Content-type' => 'text/html'),
                file_get_contents($this->_dataDir . 'rdfaTestResource1.html')
            )
        );

        $this->assertTrue($this->_wrapper->isAvailable($r, null));
    }

    public function testRunAvailableData()
    {
        $r = new Erfurt_Rdf_Resource('http://www.example.org/rdfaTestResource1.html');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(
            new Zend_Http_Response(
                200,
                array(),
                file_get_contents($this->_dataDir . 'rdfaTestResource1.html')
            )
        );

        $result = $this->_wrapper->run($r, null);
        $this->assertEquals(
            array (
                '_:genid1' => array (
                    'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' => array (
                        0 => array (
                           'type' => 'uri',
                           'value' => 'http://schema.org/PostalAdress',
                        ),
                    ),
                    'http://schema.org/streetAddress' => array (
                        0 => array (
                            'type' => 'literal',
                            'value' => 'Augustusplatz 10',
                            'lang' => 'en',
                        ),
                    ),
                    'http://aksw.org/schema/room' => array (
                        0 => array (
                            'type' => 'literal',
                            'value' => 'A123',
                            'lang' => 'en',
                        ),
                    ),
                    'http://schema.org/postalCode' => array (
                        0 => array (
                            'type' => 'literal',
                            'value' => '04109',
                            'lang' => 'en',
                        ),
                    ),
                    'http://schema.org/addressLocality' => array (
                        0 => array (
                            'type' => 'literal',
                            'value' => 'Leipzig',
                            'lang' => 'en',
                        ),
                    ),
                ),
                'http://www.example.org/rdfaTestResource1.html' => array (
                    'http://schema.org/location' => array (
                        0 => array (
                            'type' => 'bnode',
                            'value' => '_:genid1',
                        ),
                    ),
                ),
            ),
            $result['add']
        );

        $this->assertEquals(
            array(Erfurt_Wrapper::NO_MODIFICATIONS, Erfurt_Wrapper::RESULT_HAS_ADD),
            $result['status_codes']
        );
    }

    public function testRunNoData()
    {
        $r = new Erfurt_Rdf_Resource('http://example.org/testResource5');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $this->_wrapper->setHttpAdapter($adapter);
        $adapter->setResponse(
            new Zend_Http_Response(
                404,
                array(),
                null
            )
        );

        $this->assertFalse($this->_wrapper->run($r, null));
    }
}

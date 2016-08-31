<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Syntax_RdfSerializerIntegrationTest extends Erfurt_TestCase
{
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
     * @access protected
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object = new Erfurt_Syntax_RdfSerializer();
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeGraphToStringWithRdfXml($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('rdfxml');
        $result1 = $this->_object->serializeGraphToString($g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
        $result2 = $adapter->serializeGraphToString($g);

        $this->assertEquals($result1, $result2);
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeResourceToStringWithRdfXml($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('rdfxml');
        $result1 = $this->_object->serializeResourceToString($g, $g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
        $result2 = $adapter->serializeResourceToString($g, $g);

        $this->assertEquals($result1, $result2);
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeGraphToStringWithRdfJson($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('rdfjson');
        $result1 = $this->_object->serializeGraphToString($g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
        $result2 = $adapter->serializeGraphToString($g);

        $this->assertEquals($result1, $result2);
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeResourceToStringWithRdfJson($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('rdfjson');
        $result1 = $this->_object->serializeResourceToString($g, $g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
        $result2 = $adapter->serializeResourceToString($g, $g);

        $this->assertEquals($result1, $result2);
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeGraphToStringWithN3($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('ttl');
        $result1 = $this->_object->serializeGraphToString($g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
        $result2 = $adapter->serializeGraphToString($g);

        $this->assertEquals($result1, $result2);
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeResourceToStringWithN3($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        $g = 'http://localhost/OntoWiki/Config/';

        $this->_object->initializeWithFormat('ttl');
        $result1 = $this->_object->serializeResourceToString($g, $g);

        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
        $result2 = $adapter->serializeResourceToString($g, $g);

        $this->assertEquals($result1, $result2);
    }
}

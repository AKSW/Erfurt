<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Store_Adapter_EfZendDbIntegrationTest extends Erfurt_TestCase
{
    public $fixture = null;

    public function setUp()
    {
        $this->markTestNeedsZendDbStore();

        $config = Erfurt_App::getInstance()->getConfig();
        $adapterOptions = $config->store->zenddb->toArray();

        $this->fixture = new Erfurt_Store_Adapter_EfZendDb($adapterOptions);
    }

    public function testSparqlQuery()
    {
        $result = $this->fixture->sparqlQuery('SELECT * WHERE {?s ?p ?o} LIMIT 1');

        $this->assertInternalType('array', $result);
        $this->assertEquals(1, count($result));
    }

    public function testSerialization()
    {
        $a = $this->fixture->sparqlQuery('SELECT * WHERE {?s ?p ?o} LIMIT 10');

        $this->assertInternalType('array', $a);
        $this->assertEquals(10, count($a));

        $this->fixture = unserialize(serialize($this->fixture));
        $b = $this->fixture->sparqlQuery('SELECT * WHERE {?s ?p ?o} LIMIT 5');

        $this->assertInternalType('array', $b);
        $this->assertEquals(5, count($b));
    }
}

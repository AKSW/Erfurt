<?php
class Erfurt_Sparql_EngineDb_ResultRenderer_ExtendedIntegrationTest extends Erfurt_TestCase
{
    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testResultHeadVarsHaveCorrectName($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        
        $store = Erfurt_App::getInstance()->getStore();
        $sparql = Erfurt_Sparql_SimpleQuery::initWithString('SELECT ?s ?p ?o WHERE { ?s ?p ?o } LIMIT 10');
        $result = $store->sparqlQuery($sparql, array('result_format' => 'extended'));
        $head = $result['head'];
        
        $this->assertEquals('s', $head['vars'][0]);
        $this->assertEquals('p', $head['vars'][1]);
        $this->assertEquals('o', $head['vars'][2]);
    }
}

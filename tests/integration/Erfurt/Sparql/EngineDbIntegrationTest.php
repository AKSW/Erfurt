<?php
class Erfurt_Sparql_EngineDbIntegrationTest extends Erfurt_TestCase
{
    private $_resourceDir = null;

    public function setUp()
    {
        $this->_resourceDir = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR;
    }

    public function testOdFmiLimitQueryWithZendDbIssue782WithLimit()
    {
        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();

        $store = Erfurt_App::getInstance()->getStore();

        $store->getNewModel('http://od.fmi.uni-leipzig.de/model/');
        $store->importRdf('http://od.fmi.uni-leipzig.de/model/', $this->_resourceDir . 'fmi.rdf', 'rdf');
        
        $store->getNewModel('http://od.fmi.uni-leipzig.de/s10/');
        $store->importRdf('http://od.fmi.uni-leipzig.de/s10/', $this->_resourceDir . 'fmi-s10.rdf', 'rdf');

        $sparql = 'PREFIX od: <http://od.fmi.uni-leipzig.de/model/>
        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
        SELECT DISTINCT ?lv ?titel ?typ ?wtyp ?von ?bis ?tag ?raum
        FROM <http://od.fmi.uni-leipzig.de/s10/>
        WHERE {{
         ?lv a od:LV . ?lv rdf:type ?typ .
         ?lv rdfs:label ?titel .
         ?lv od:dayOfWeek ?tag .} OPTIONAL {
         ?lv od:locatedAt ?raum .
         ?lv od:startTime ?von .
         ?lv od:endTime ?bis .
         ?lv od:typeOfWeek ?wtyp .
        }} LIMIT 20';

        $result = $store->sparqlQuery($sparql, array(Erfurt_Store::RESULTFORMAT => 'extended'));
        $this->assertEquals(20, count($result['bindings']));

        foreach ($result['bindings'] as $row) {
            $this->assertTrue(array_key_exists('lv', $row));
            $this->assertTrue(array_key_exists('titel', $row));
            $this->assertTrue(array_key_exists('typ', $row));
            $this->assertTrue(array_key_exists('wtyp', $row));
            $this->assertTrue(array_key_exists('von', $row));
            $this->assertTrue(array_key_exists('bis', $row));
            $this->assertTrue(array_key_exists('tag', $row));
            $this->assertTrue(array_key_exists('raum', $row));
            
            if ($row['raum']['type'] !== null) {
                $this->assertEquals('uri', $row['raum']['type']); // raum binding is optional
            }
        }
    }
    
    public function testOdFmiLimitQueryWithZendDbIssue782WithoutLimit()
    {
        $this->markTestNeedsZendDb();
        $this->authenticateDbUser();

        $store = Erfurt_App::getInstance()->getStore();

        $store->getNewModel('http://od.fmi.uni-leipzig.de/model/');
        $store->importRdf('http://od.fmi.uni-leipzig.de/model/', $this->_resourceDir . 'fmi.rdf', 'rdf');
        
        $store->getNewModel('http://od.fmi.uni-leipzig.de/s10/');
        $store->importRdf('http://od.fmi.uni-leipzig.de/s10/', $this->_resourceDir . 'fmi-s10.rdf', 'rdf');

        $sparql = 'PREFIX od: <http://od.fmi.uni-leipzig.de/model/>
        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
        SELECT DISTINCT ?lv ?titel ?typ ?wtyp ?von ?bis ?tag ?raum
        FROM <http://od.fmi.uni-leipzig.de/s10/>
        WHERE {{
         ?lv a od:LV . ?lv rdf:type ?typ .
         ?lv rdfs:label ?titel .
         ?lv od:dayOfWeek ?tag .} OPTIONAL {
         ?lv od:locatedAt ?raum .
         ?lv od:startTime ?von .
         ?lv od:endTime ?bis .
         ?lv od:typeOfWeek ?wtyp .
        }}';

        $result = $store->sparqlQuery($sparql, array(Erfurt_Store::RESULTFORMAT => 'extended'));
        $this->assertEquals(680, count($result['bindings']));

        foreach ($result['bindings'] as $row) {
            $this->assertTrue(array_key_exists('lv', $row));
            $this->assertTrue(array_key_exists('titel', $row));
            $this->assertTrue(array_key_exists('typ', $row));
            $this->assertTrue(array_key_exists('tag', $row));
            $this->assertTrue(array_key_exists('wtyp', $row));
            $this->assertTrue(array_key_exists('von', $row));
            $this->assertTrue(array_key_exists('bis', $row));
            $this->assertTrue(array_key_exists('raum', $row));
            
            if ($row['raum']['type'] !== null) {
                $this->assertEquals('uri', $row['raum']['type']); // raum binding is optional
            }
        }
    }
}

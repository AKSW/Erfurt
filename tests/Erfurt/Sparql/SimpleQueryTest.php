<?php
require_once 'test_base.php';
require_once 'Erfurt/Sparql/SimpleQuery.php';

class Erfurt_Sparql_SimpleQueryTest extends PHPUnit_Framework_TestCase
{
    public function testInitWithString()
    {
        $queryString = '
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX dc: <http://purl.org/dc/elements/1.1/>

            SELECT ?productLabel ?offer ?price ?vendor ?vendorTitle ?review ?revTitle 
                   ?reviewer ?revName ?rating1 ?rating2
            WHERE { 
            	<http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/instances/dataFromProducer1/Product1> rdfs:label ?productLabel .
                OPTIONAL {
                    ?offer bsbm:product <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/instances/dataFromProducer1/Product1> .
            		?offer bsbm:price ?price .
            		?offer bsbm:vendor ?vendor .
            		?vendor rdfs:label ?vendorTitle .
                    ?vendor bsbm:country <http://downlode.org/rdf/iso-3166/countries#DE> .
                    ?offer dc:publisher ?vendor . 
                    ?offer bsbm:validTo ?date .
                    FILTER (?date >"2008-06-20T00:00:00"^^<http://www.w3.org/2001/XMLSchema#dateTime>)
                }
                OPTIONAL {
            	    ?review bsbm:reviewFor <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/instances/dataFromProducer1/Product1> .
            	    ?review rev:reviewer ?reviewer .
            	    ?reviewer foaf:name ?revName .
            	    ?review dc:title ?revTitle .
                    OPTIONAL { ?review bsbm:rating1 ?rating1 . }
                    OPTIONAL { ?review bsbm:rating2 ?rating2 . } 
                }
            }';
        
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        
        $expected = preg_replace('/\s/', '', $queryString);
        $actual   = preg_replace('/\s/', '', (string) $queryObject);
        
        $this->assertSame($expected, $actual);
    }
}

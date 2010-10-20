<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Sparql/SimpleQuery.php';

class Erfurt_Sparql_SimpleQueryTest extends Erfurt_TestCase
{
    public function assertQueryEquals($expected, $actual)
    {
        // remove white space and comments before query comparison
        $expectedStripped = preg_replace('/\s|#.*\n/', '', $expected);
        $actualStripped   = preg_replace('/\s|#.*\n/', '', $actual);
        
        return parent::assertEquals($expectedStripped, $actualStripped);
    }
    
    public function testInitWithStringSimple()
    {
        $queryString = '
            SELECT DISTINCT ?resource ?author ?comment ?content ?date #?alabel
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }
            ORDER BY DESC(?date)
            LIMIT 6';
        
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
    }
    
    public function testInitWithStringComplex()
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
        $this->assertQueryEquals($queryString, (string)$queryObject);
    }
    
    public function testInitWithStringUnusuallyFormatted()
    {        
        $queryString = '
            SELECT DISTINCT ?resourceUri FROM
            <http://sebastian.dietzold.de/rdf/foaf.rdf> WHERE {
            <http://sebastian.dietzold.de/terms/me>
            <http://xmlns.com/foaf/0.1/pastProject> ?resourceUri FILTER
            (isURI(?resourceUri) && !isBLANK(?resourceUri)) } ORDER BY
            ASC(?resourceUri) LIMIT 10';
        
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
    }
    
    public function testInitWithString2()
    {
        $queryString = '
            PREFIX vakp: <http://vakantieland.nl/model/properties/>
            PREFIX wgs84: <http://www.w3.org/2003/01/geo/wgs84_pos#>

            SELECT DISTINCT ?poi
            FROM <http://vakantieland.nl/model/>
            WHERE {
             ?poi vakp:isPublicPoi "true"^^xsd:boolean .
            ?poi wgs84:long ?long .
            FILTER (?long >= 5.804).
            FILTER (?long <= 6.3478).
            ?poi wgs84:lat ?lat .
            FILTER (?lat >= 52.3393) .
            FILTER (?lat <= 52.6704). 
                   ?poi vakp:ranking ?ranking
            }
            ORDER BY DESC(?ranking) ASC(?poi)
            LIMIT 10 
            OFFSET 0';
        
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
    }
    
    public function testInitWithString3()
    {
        $queryString = '                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
SELECT DISTINCT ?uri ?literal ?domain ?type                FROM <http://localhost/ontowiki/whostat>                WHERE {                    ?uri ?v1 ?literal .
                    {?v2 ?uri ?v3 .} UNION {?uri a rdf:Property .}                    OPTIONAL {?uri rdfs:domain ?domain .}
                                        OPTIONAL {<http://localhost/ontowiki/whostat> a ?type . }                    FILTER (                        isURI(?uri)                         && isLITERAL(?literal)                         && REGEX(?literal, "title", "i")                         && REGEX(?literal, "^.{1,50}$"))                }                LIMIT 5';
        
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
    }
}

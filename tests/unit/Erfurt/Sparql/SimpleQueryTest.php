<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Sparql_SimpleQueryTest extends Erfurt_TestCase
{
    public function assertEqualsNoWs($expected, $actual)
    {
        // remove white space before query comparison
        $expectedStripped = strtolower(preg_replace('/\s/', '', $expected));
        $actualStripped   = strtolower(preg_replace('/\s/', '', $actual));

        return parent::assertEquals($expectedStripped, $actualStripped);
    }
    public function assertQueryEquals($expected, $actual)
    {
        // remove comments before query comparison
        // TODO don't replace '#> …' in strings like '<http://ex.org#> …'
        $expectedStripped = preg_replace('/#.*\n/', '', $expected);
        $actualStripped   = preg_replace('/#.*\n/', '', $actual);

        return $this->assertEqualsNoWs($expectedStripped, $actualStripped);
    }

    public function testSetWithMethods()
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

        $queryObject = new Erfurt_Sparql_SimpleQuery();
        $queryObject->setSelectClause('SELECT DISTINCT ?resource ?author ?comment ?content ?date');
        $queryObject->setWherePart('WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }');
        $queryObject->setOrderClause('DESC(?date)');
        $queryObject->setLimit(6);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), false);
    }

    public function testSetWithMethodsAsk()
    {
        $queryString = '
            ASK
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }
            ORDER BY DESC(?date)
            LIMIT 6';

        $queryObject = new Erfurt_Sparql_SimpleQuery();
        $queryObject->setAsk();
        $queryObject->setWherePart('WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }');
        $queryObject->setOrderClause('DESC(?date)');
        $queryObject->setLimit(6);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), true);
        $this->assertEquals($queryObject->getSelectClause(), null);
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
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource ?author ?comment ?content ?date');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), 'DESC(?date)');
        $this->assertEquals($queryObject->getLimit(), 6);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringOrderNotBracketted()
    {
        $queryString = '
            SELECT DISTINCT ?resource ?author ?comment ?content ?date #?alabel
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }
            ORDER BY ?date';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource ?author ?comment ?content ?date');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?date');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringOrderNotBrackettedLimitNoDistinct()
    {
        $queryString = '
            SELECT ?resource ?author ?comment ?content ?date #?alabel
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }
            ORDER BY ?date
            LIMIT 6';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT ?resource ?author ?comment ?content ?date');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?date');
        $this->assertEquals($queryObject->getLimit(), 6);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringOrderNotBrackettedOffset()
    {
        $queryString = '
            SELECT DISTINCT ?resource ?author ?comment ?content ?date #?alabel
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }
            ORDER BY ?date
            OFFSET 6';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?date');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), 6);
    }

    public function testInitWithStringCount()
    {
        $queryString = '
            SELECT DISTINCT ?resource count(?comment)
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
            }
            ORDER BY ?comment';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource count(?comment)');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?comment');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringCountAs()
    {
        $queryString = '
            SELECT DISTINCT ?resource count(?comment) as ?c
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
            }
            ORDER BY ?c';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource count(?comment) as ?c');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?c');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringCountAsNewlines()
    {
        $queryString = '
            BASE
            <http://example.org/>
            PREFIX
            rdfs:
            <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#> PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm:
            <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX
            dc:
            <http://purl.org/dc/elements/1.1/>

            SELECT
            DISTINCT
            ?resource
            count
            (?comment)
            as
            ?c
            WHERE {
                ?comment
                    <http://rdfs.org/sioc/ns#about>
                    ?resource.
            }
    ORDER
        BY
        ?c';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), 'BASE <http://example.org/>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX dc: <http://purl.org/dc/elements/1.1/>');
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource count(?comment) as ?c');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?c');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringComplex()
    {
        $queryString = '
            BASE <http://example.org/>
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
        $this->assertEqualsNoWs($queryObject->getProloguePart(), 'BASE <http://example.org/>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX dc: <http://purl.org/dc/elements/1.1/>');
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT ?productLabel ?offer ?price ?vendor ?vendorTitle ?review ?revTitle ?reviewer ?revName ?rating1 ?rating2');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {
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
            }');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), null);
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringAsk()
    {
        $queryString = '
            ASK
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), null);
        $this->assertEquals($queryObject->isAsk(), true);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), null);
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?s ?p ?o}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), null);
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringStar()
    {
        $queryString = '
            SELECT *
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), null);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT *');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?s ?p ?o}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), null);
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringCountStar()
    {
        $queryString = '
            SELECT COUNT(*)
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), null);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT count(*)');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?s ?p ?o}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), null);
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringVarAndCountStar()
    {
        $queryString = '
            SELECT DISTINCT ?resource count(*)
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
            }
            ORDER BY ?comment';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), null);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resource count(*)');
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), '?comment');
        $this->assertEquals($queryObject->getLimit(), null);
        $this->assertEquals($queryObject->getOffset(), null);
    }

    public function testInitWithStringUnusuallyFormatted()
    {
        $queryString = '
            SELECT DISTINCT ?resourceUri FROM
            <http://sebastian.dietzold.de/rdf/foaf.rdf> WHERE {
            <http://sebastian.dietzold.de/terms/me>
            <http://xmlns.com/foaf/0.1/pastProject> ?resourceUri FILTER
            (isURI(?resourceUri) && !isBLANK(?resourceUri)) } ORDER BY
            ASC( ?resourceUri) LIMIT 10';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs($queryObject->getProloguePart(), null);
        $this->assertEquals($queryObject->isAsk(), false);
        $this->assertEqualsNoWs($queryObject->getSelectClause(), 'SELECT DISTINCT ?resourceUri');
        $this->assertEquals($queryObject->getFrom(), array('http://sebastian.dietzold.de/rdf/foaf.rdf'));
        $this->assertEqualsNoWs($queryObject->getWherePart(), 'WHERE { <http://sebastian.dietzold.de/terms/me> <http://xmlns.com/foaf/0.1/pastProject> ?resourceUri FILTER (isURI(?resourceUri) && !isBLANK(?resourceUri)) }');
        $this->assertEqualsNoWs($queryObject->getOrderClause(), 'asc(?resourceUri)');
        $this->assertEquals($queryObject->getLimit(), 10);
        $this->assertEquals($queryObject->getOffset(), null);
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

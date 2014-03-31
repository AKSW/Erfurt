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
        $this->assertEquals(false, $queryObject->isAsk());
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
        $this->assertEquals(true, $queryObject->isAsk());
        $this->assertEquals(null, $queryObject->getSelectClause());
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
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource ?author ?comment ?content ?date', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
                ?comment a <http://rdfs.org/sioc/types#Comment>.
                ?comment <http://rdfs.org/sioc/ns#has_creator> ?author.
                ?comment <http://rdfs.org/sioc/ns#content> ?content.
                ?comment <http://purl.org/dc/terms/created> ?date.
            }', $queryObject->getWherePart());
        $this->assertEqualsNoWs('DESC(?date)', $queryObject->getOrderClause());
        $this->assertEquals(6, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource ?author ?comment ?content ?date', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?date', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT ?resource ?author ?comment ?content ?date', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource;
                         a <http://rdfs.org/sioc/types#Comment>;
                         <http://rdfs.org/sioc/ns#has_creator> ?author;
                         <http://rdfs.org/sioc/ns#content> ?content;
                         <http://purl.org/dc/terms/created> ?date.
            }', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?date', $queryObject->getOrderClause());
        $this->assertEquals(6, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('?date', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(6, $queryObject->getOffset());
    }

    public function testInitWithStringOrderExpression()
    {
        $queryString = '
            SELECT DISTINCT ?resource count(?comment)
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
            }
            ORDER BY LANG(?comment) limit 10';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(?comment)', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('LANG(?comment)', $queryObject->getOrderClause());
        $this->assertEquals(10, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
    }

    public function testInitWithStringOrderExpression2()
    {
        $queryString = '
            SELECT DISTINCT ?resource count(?comment)
            WHERE {
                ?comment <http://rdfs.org/sioc/ns#about> ?resource.
            }
            ORDER BY asc(LANG(?comment)) limit 10';

        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(?comment)', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('ASC(LANG(?comment))', $queryObject->getOrderClause());
        $this->assertEquals(10, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(?comment)', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?comment', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(?comment) as ?c', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?c', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs('BASE <http://example.org/>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX dc: <http://purl.org/dc/elements/1.1/>', $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(?comment) as ?c', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?c', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs('BASE <http://example.org/>
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX rev: <http://purl.org/stuff/rev#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
            PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
            PREFIX dc: <http://purl.org/dc/elements/1.1/>', $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT ?productLabel ?offer ?price ?vendor ?vendorTitle ?review ?revTitle ?reviewer ?revName ?rating1 ?rating2', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {
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
            }', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(true, $queryObject->isAsk());
        $this->assertEqualsNoWs(null, $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
    }

    public function testInitWithStringFrom()
    {
        $queryString = '
            SELECT ?s
            FROM <http://example.org/>
            FROM <http://example.com/>
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT ?s', $queryObject->getSelectClause());
        $this->assertEquals(array('http://example.org/', 'http://example.com/'), $queryObject->getFrom());
        $this->assertEquals(array(), $queryObject->getFromNamed());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
    }

    public function testInitWithStringFromNamed()
    {
        $queryString = '
            ASK
            FROM NAMED <http://example.org/>
            FROM NAMED <http://example.com/>
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(true, $queryObject->isAsk());
        $this->assertEqualsNoWs(null, $queryObject->getSelectClause());
        $this->assertEquals(array(), $queryObject->getFrom());
        $this->assertEquals(array('http://example.org/', 'http://example.com/'), $queryObject->getFromNamed());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
    }

    public function testInitWithStringFromAndFromNamed()
    {
        $queryString = '
            ASK
            FROM <http://example.org/>
            FROM NAMED <http://example.com/>
            WHERE {
                ?s ?p ?o
            }
        ';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryString);
        $this->assertQueryEquals($queryString, (string)$queryObject);
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(true, $queryObject->isAsk());
        $this->assertEqualsNoWs(null, $queryObject->getSelectClause());
        $this->assertEquals(array('http://example.org/'), $queryObject->getFrom());
        $this->assertEquals(array('http://example.com/'), $queryObject->getFromNamed());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT *', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT count(*)', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?s ?p ?o}', $queryObject->getWherePart());
        $this->assertEqualsNoWs(null, $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resource count(*)', $queryObject->getSelectClause());
        $this->assertEqualsNoWs('WHERE {?comment <http://rdfs.org/sioc/ns#about> ?resource.}', $queryObject->getWherePart());
        $this->assertEqualsNoWs('?comment', $queryObject->getOrderClause());
        $this->assertEquals(null, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs(null, $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?resourceUri', $queryObject->getSelectClause());
        $this->assertEquals(array('http://sebastian.dietzold.de/rdf/foaf.rdf'), $queryObject->getFrom());
        $this->assertEqualsNoWs('WHERE { <http://sebastian.dietzold.de/terms/me> <http://xmlns.com/foaf/0.1/pastProject> ?resourceUri FILTER (isURI(?resourceUri) && !isBLANK(?resourceUri)) }', $queryObject->getWherePart());
        $this->assertEqualsNoWs('asc(?resourceUri)', $queryObject->getOrderClause());
        $this->assertEquals(10, $queryObject->getLimit());
        $this->assertEquals(null, $queryObject->getOffset());
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
        $this->assertEqualsNoWs('PREFIX vakp: <http://vakantieland.nl/model/properties/> PREFIX wgs84: <http://www.w3.org/2003/01/geo/wgs84_pos#>', $queryObject->getProloguePart());
        $this->assertEquals(false, $queryObject->isAsk());
        $this->assertEqualsNoWs('SELECT DISTINCT ?poi', $queryObject->getSelectClause());
        $this->assertEquals(array('http://vakantieland.nl/model/'), $queryObject->getFrom());
        $this->assertEqualsNoWs('WHERE { ?poi vakp:isPublicPoi "true"^^xsd:boolean .  ?poi wgs84:long ?long .
            FILTER (?long >= 5.804).  FILTER (?long <= 6.3478).  ?poi wgs84:lat ?lat .
            FILTER (?lat >= 52.3393) .  FILTER (?lat <= 52.6704).  ?poi vakp:ranking ?ranking }', $queryObject->getWherePart());
        $this->assertEqualsNoWs('desc(?ranking) asc(?poi)', $queryObject->getOrderClause());
        $this->assertEquals(10, $queryObject->getLimit());
        $this->assertEquals(0, $queryObject->getOffset());
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

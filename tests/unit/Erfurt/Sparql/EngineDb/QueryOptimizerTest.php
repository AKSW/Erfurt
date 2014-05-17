<?php

/**
 * Tests the query optimizer.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 17.05.14
 */
class Erfurt_Sparql_EngineDb_QueryOptimizerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Sparql_EngineDb_QueryOptimizer
     */
    protected $optimizer = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $connection      = new Zend_Db_Adapter_Pdo_Sqlite(array('dbname' => ':memory:'));
        $engine          = new Erfurt_Sparql_EngineDb_Adapter_EfZendDb($connection);
        $this->optimizer = new Erfurt_Sparql_EngineDb_QueryOptimizer($engine);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->optimizer = null;
        parent::tearDown();
    }

    /**
     * Checks if the optimizer an handle a DISTINCT query with a FILTER expression that contains
     * "0" as an operand.
     */
    public function testOptimizerCanHandleDistinctQueryWithZeroAsFilterOperand()
    {
        $query = 'PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                  PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                  PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                  SELECT DISTINCT ?var3 ?var5 ?var7
                  FROM <http://dbpedia.org>
                  WHERE {
                      ?var3 rdf:type <http://dbpedia.org/class/yago/Company108058098> .
                      ?var3 <http://dbpedia.org/numEmployees> ?var5 .
                      ?var3 foaf:homepage ?var7 .
                      FILTER ( xsd:integer(?var5) >= 0 ) .
                  }';
        $parser = new Erfurt_Sparql_Parser();
        $query = $parser->parse($query);

        $result = $this->optimizer->optimize($query);

        $this->assertInstanceOf('Erfurt_Sparql_Query', $result);
    }

}

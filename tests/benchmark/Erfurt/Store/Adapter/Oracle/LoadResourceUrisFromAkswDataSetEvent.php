<?php

use Faker\Generator;

/**
 * Checks the performance of the query that selects the resource URIs from the AKSW data set.
 *
 * The problems with this query are documented at {@link https://github.com/Matthimatiker/Erfurt/issues/31}.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.02.14
 */
class Erfurt_Store_Adapter_Oracle_LoadResourceUrisFromAkswDataSetEvent
    extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
{

    /**
     * Loads the AKSW data set.
     *
     * @param \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     * @param \Faker\Generator $faker
     */
    public function populateStore(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector, Generator $faker)
    {
        $path = __DIR__ . '/_files/aksw.rdf';
        $parser     = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
        $statements = $parser->parseFromFilename($path);
        $triples    = new Erfurt_Store_Adapter_Sparql_TripleIterator($statements);
        foreach ($triples as $triple) {
            /* @var $triple Erfurt_Store_Adapter_Sparql_Triple */
            $this->connector->addTriple('http://localhost/OntoWiki/aksw', $triple);
        }
    }

    /**
     * Executes the query without modifications.
     *
     * @Iterations 10
     */
    public function executeQuery()
    {
        $query = 'SELECT DISTINCT ?resourceUri '
               . 'FROM <http://localhost/OntoWiki/aksw> '
               . 'WHERE { '
               . '     { '
               . '        ?sub <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?resourceUri '
               . '    } UNION { '
               . '        ?sub <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?resourceUri '
               . '    } OPTIONAL { '
               . '        ?resourceUri <http://ns.ontowiki.net/SysOnt/hidden> ?reg '
               . '    } OPTIONAL { '
               . '         ?resourceUri <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?super '
               . '    } '
               . '    FILTER (!isBLANK(?resourceUri)) '
               . '    FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/1999/02/22-rdf-syntax-ns#")) '
               . '    FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2000/01/rdf-schema#")) '
               . '    FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2002/07/owl#")) '
               . '    FILTER (!BOUND(?reg)) '
               . '    FILTER (REGEX(STR(?super), "^http://www.w3.org/2002/07/owl#") || !BOUND(?super)) '
               . '} '
               . 'LIMIT 11';
        $this->connector->query($query);
    }

    /**
     * Executes the query with multiple REGEX filters combined into one.
     *
     * @Iterations 10
     */
    public function testExecuteQueryWithCombinedRegularExpressions()
    {
        $query = 'SELECT DISTINCT ?resourceUri '
               . 'FROM <http://localhost/OntoWiki/aksw> '
               . 'WHERE { '
               . '     { '
               . '        ?sub <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?resourceUri '
               . '    } UNION { '
               . '        ?sub <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?resourceUri '
               . '    } OPTIONAL { '
               . '        ?resourceUri <http://ns.ontowiki.net/SysOnt/hidden> ?reg '
               . '    } OPTIONAL { '
               . '         ?resourceUri <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?super '
               . '    } '
               . '    FILTER (!isBLANK(?resourceUri)) '
               . '    FILTER (!REGEX(STR(?resourceUri), "(^http://www.w3.org/1999/02/22-rdf-syntax-ns#|^http://www.w3.org/2000/01/rdf-schema#|^http://www.w3.org/2002/07/owl#)")) '
               . '    FILTER (!BOUND(?reg)) '
               . '    FILTER (REGEX(STR(?super), "^http://www.w3.org/2002/07/owl#") || !BOUND(?super)) '
               . '} '
               . 'LIMIT 11';
        $this->connector->query($query);
    }

    /**
     * Executes the query with REGEX filters moved to each part of the UNION statement.
     *
     * @Iterations 10
     */
    public function testExecuteQueryWithFiltersInUnionParts()
    {
        $query = 'SELECT DISTINCT ?resourceUri '
               . 'FROM <http://localhost/OntoWiki/aksw> '
               . 'WHERE { '
               . '     { '
               . '        ?sub <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?resourceUri '
               . '        FILTER (!isBLANK(?resourceUri)) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/1999/02/22-rdf-syntax-ns#")) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2000/01/rdf-schema#")) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2002/07/owl#")) '
               . '    } UNION { '
               . '        ?sub <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?resourceUri '
               . '        FILTER (!isBLANK(?resourceUri)) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/1999/02/22-rdf-syntax-ns#")) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2000/01/rdf-schema#")) '
               . '        FILTER (!REGEX(STR(?resourceUri), "^http://www.w3.org/2002/07/owl#")) '
               . '    } OPTIONAL { '
               . '        ?resourceUri <http://ns.ontowiki.net/SysOnt/hidden> ?reg '
               . '    } OPTIONAL { '
               . '         ?resourceUri <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?super '
               . '    } '
               . '    FILTER (!BOUND(?reg)) '
               . '    FILTER (REGEX(STR(?super), "^http://www.w3.org/2002/07/owl#") || !BOUND(?super)) '
               . '} '
               . 'LIMIT 11';
        $this->connector->query($query);
    }

}

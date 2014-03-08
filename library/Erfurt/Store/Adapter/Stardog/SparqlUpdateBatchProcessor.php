<?php

/**
 * Batch processor that uses SPARQL update queries to store quads.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 */
class Erfurt_Store_Adapter_Stardog_SparqlUpdateBatchProcessor
    implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The data access client that is used to interact with the store.
     *
     * @var Erfurt_Store_Adapter_Stardog_DataAccessClient
     */
    protected $client = null;

    /**
     * Creates a batch processor that uses the provided data access client.
     *
     * @param Erfurt_Store_Adapter_Stardog_DataAccessClient $client
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_DataAccessClient $client)
    {
        $this->client = $client;
    }

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        if (count($quads) === 0) {
            return;
        }
        $triplesByGraph = array();
        foreach ($quads as $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            if (!isset($triplesByGraph[$quad->getGraph()])) {
                $triplesByGraph[$quad->getGraph()] = array();
            }
            $triplesByGraph[$quad->getGraph()][] = (string)$quad;
        }

        $graphGroups = array();
        foreach ($triplesByGraph as $graph => $triples) {
            /* @var $graph string */
            /* @var $triples array(string) */
            $graphGroups[] = 'GRAPH <' . $graph . '> {'
                           . implode(PHP_EOL, $triples)
                           . '}';
        }
        $query = 'INSERT DATA { ' . implode(PHP_EOL, $graphGroups) . '}';
        $this->client->query($query);
    }

}

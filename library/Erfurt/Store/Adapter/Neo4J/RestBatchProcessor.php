<?php

/**
 * Processor that uses the Batch REST API to store quads.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 19.05.14
 */
class Erfurt_Store_Adapter_Neo4J_RestBatchProcessor implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The REST client that is used to communicate with Neo4j.
     *
     * @var \Erfurt_Store_Adapter_Neo4J_ApiClient
     */
    protected $apiClient = null;

    /**
     * Creates a batch processor that uses the REST API.
     *
     * @param \Erfurt_Store_Adapter_Neo4J_ApiClient $apiClient
     */
    public function __construct(Erfurt_Store_Adapter_Neo4J_ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Stores the provided quads.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        $batch = new Erfurt_Store_Adapter_Neo4J_ApiCallBatch();

        foreach ($quads as $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            $subjectTerm = $quad->format('?subject');
            $subjectCommand = $this->apiClient->buildCreateUniqueNodeCommand('rdf-node', $subjectTerm, array(
                'term'  => $subjectTerm,
                'kind'  => ((strpos($quad->getSubject(), '_:') === 0) ? 'bnode' : 'uri'),
                'value' => $quad->getSubject()
            ));
            $subjectNode = $batch->addJob($subjectCommand);

            $object     = $quad->getObject();
            $objectTerm = $quad->format('?object');
            $objectProperties = array(
                'term'  => $objectTerm,
                'kind'  => $object['type'],
                'value' => (string)$object['value']
            );
            if (isset($object['lang']) && !empty($object['lang'])) {
                $objectProperties['lang'] = $object['lang'];
            } else if (isset($object['datatype']) && !empty($object['datatype'])) {
                $objectProperties['type'] = $object['datatype'];
            }
            $objectCommand = $this->apiClient->buildCreateUniqueNodeCommand('rdf-node', $objectTerm, $objectProperties);
            $objectNode    = $batch->addJob($objectCommand);

            $relationCommand = $this->apiClient->buildCreateUniqueRelationCommand(
                'rdf-predicate',
                $subjectTerm . ' -(' . $quad->getPredicate() . ')-> ' . $objectTerm,
                $subjectNode,
                $objectNode,
                $quad->getPredicate(),
                array(
                    'c'  => 'U ' . $quad->getGraph(),
                    'p'  => 'U ' . $quad->getPredicate(),
                    'cp' => 'U ' . $quad->getGraph() . ' U ' . $quad->getPredicate()
                )
            );
            $batch->addJob($relationCommand);
        }

        $this->apiClient->executeBatch($batch);
    }

}

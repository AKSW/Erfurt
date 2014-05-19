<?php

/**
 * Used to manage a Neo4J triple store.
 *
 * This client assumes that the whole Neo4J database is used as triple store only.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_StoreManagementClient implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The REST client that is used to communicate with Neo4j.
     *
     * @var \Erfurt_Store_Adapter_Neo4J_ApiClient
     */
    protected $apiClient = null;

    /**
     * Creates a management client that uses the provided REST API
     * client to communicate with the store.
     *
     * @param \Erfurt_Store_Adapter_Neo4J_ApiClient $apiClient
     */
    public function __construct(Erfurt_Store_Adapter_Neo4J_ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Adds the provided triple to the graph.
     *
     * @param string $graphUri
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple($graphUri, Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        $this->persist(array(Erfurt_Store_Adapter_Sparql_Quad::create($graphUri, $triple)));
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

    /**
     * Deletes all triples in the given graph that match the provided pattern.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_TriplePattern $pattern
     * @return integer The number of deleted triples.
     */
    public function deleteMatchingTriples($graphIri, Erfurt_Store_Adapter_Sparql_TriplePattern $pattern)
    {
        $params = array('graph' => 'U ' . $graphIri);
        $conditions = array();
        if ($pattern->getSubject() !== null) {
            $conditions[] = '(subject.value={subjectValue} and subject.kind={subjectType})';
            $params['subjectValue'] = $pattern->getSubject();
            $params['subjectType']  = 'uri';
        }
        if ($pattern->getPredicate() !== null) {
            $conditions[] = '(r.p={predicate})';
            $params['predicate'] = 'U ' . $pattern->getPredicate();
        }
        if ($pattern->getObject() !== null) {
            $conditions[] = '(object.value={objectValue} and object.kind={objectType})';
            $object = $pattern->getObject();
            $params['objectValue'] = (string)$object['value'];
            $params['objectType']  = $object['type'];
            if (isset($object['datatype']) && !empty($object['datatype'])) {
                $conditions[] = 'object.type! = {objectDataType}';
                $params['objectDataType'] = $object['datatype'];
            } else {
                $conditions[] = 'NOT(HAS(object.type))';
            }
            if (isset($object['lang']) && !empty($object['lang'])) {
                $conditions[] = 'object.lang! = {objectLang}';
                $params['objectLang'] = $object['lang'];
            } else {
                $conditions[] = 'NOT(HAS(object.lang))';
            }
        }
        $query = 'START r=relationship:relationship_auto_index(c={graph}) '
               . 'MATCH (subject)-[r]->(object) ';
        if (count($conditions) > 0) {
            $query .= 'WHERE ' . implode(' and ', $conditions) . ' ';
        }
        $query .= 'DELETE r ';
        $query .= 'RETURN COUNT(r) AS deletedTriples';
        $result = $this->executeCypherQuery($query, $params);
        return $result[0]['deletedTriples'];
    }

    /**
     * Removes all triples in the database.
     */
    public function clear()
    {
        $deleteNodesAndPredicates = 'START n=node(*) MATCH (n)-[r?]-() WHERE HAS(n.term) DELETE r, n';
        $this->executeCypherQuery($deleteNodesAndPredicates);
    }

    /**
     * Returns the number of triples in the store.
     *
     * @return integer
     */
    public function getNumberOfTriples()
    {
        // Determine the number of edges, which is equivalent to the number of triples
        // as each triple has its own predicate (but subject and object might be shared
        // between triples).
        $query  = 'START n=node(*) MATCH (n)-[r]->() WHERE HAS(n.term) RETURN COUNT(r) AS numberOfTriples';
        $result = $this->executeCypherQuery($query);
        return $result[0]['numberOfTriples'];
    }

    /**
     * Executes the provided Cypher query and returns the results.
     *
     * @param string $query
     * @param array(string=>mixed) $params
     * @return array(string=>mixed)
     */
    protected function executeCypherQuery($query, array $params = array())
    {
        return $this->apiClient->query($query, $params);
    }

}

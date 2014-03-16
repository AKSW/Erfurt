<?php

use Everyman\Neo4j\Client;
use Everyman\Neo4j\Cypher\Query;

/**
 * Used to manage a Neo4J triple store.
 *
 * This client assumes that the whole Neo4J database is used as triple store only.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.03.14
 */
class Erfurt_Store_Adapter_Neo4J_StoreManagementClient
{

    /**
     * The REST client that is used to communicate with Neo4J.
     *
     * @var \Everyman\Neo4j\Client
     */
    protected $apiClient = null;

    /**
     * Creates a management client that uses the provided REST API
     * client to communicate with the store.
     *
     * @param Client $restApiClient
     */
    public function __construct(Client $restApiClient)
    {
        $this->apiClient = $restApiClient;
    }

    /**
     * Adds the provided triple to the graph.
     *
     * @param string $graphUri
     * @param Erfurt_Store_Adapter_Sparql_Triple $triple
     */
    public function addTriple($graphUri, Erfurt_Store_Adapter_Sparql_Triple $triple)
    {
        $object = $triple->getObject();
        $params = array(
            'subjectTerm'   => $triple->format('?subject'),
            'subjectValue'  => $triple->getSubject(),
            'subjectKind'   => ((strpos($triple->getSubject(), '_:') === 0) ? 'bnode' : 'uri'),
            'predicateType' => $triple->getPredicate(),
            'predicateC'    => 'U ' . $graphUri,
            'predicateP'    => 'U ' . $triple->getPredicate(),
            'predicateCP'   => 'U ' . $graphUri . ' U ' . $triple->getPredicate(),
            'objectTerm'    => $triple->format('?object'),
            'objectValue'   => (($object['type'] === 'literal') ? $triple->format('?object') : $object['value']),
            'objectKind'    => $object['type']
        );

        $query = 'START subject=node(*) WHERE subject.term={subjectTerm} RETURN ID(subject) AS subjectId';
        $result = $this->executeCypherQuery($query, $params);
        $subjectId = null;
        if (count($result) > 0) {
            $subjectId = $result[0]['subjectId'];
        }
        $query = 'START object=node(*) WHERE object.term={objectTerm} RETURN ID(object) AS objectId';
        $result = $this->executeCypherQuery($query, $params);
        $objectId = null;
        if (count($result) > 0) {
            $objectId = $result[0]['objectId'];
        }

        $subjectDefinition   = '(subject {value: {subjectValue}, kind: {subjectKind}, term: {subjectTerm}})';
        $predicateDefinition = '[r:`' . $triple->getPredicate() . '` {c: {predicateC}, cp: {predicateCP}, p: {predicateP}}]';
        $objectProperties = 'value: {objectValue}, kind: {objectKind}, term: {objectTerm}';
        if (isset($object['lang']) && !empty($object['lang'])) {
            $params['objectLang'] = $object['lang'];
            $objectProperties .= ', lang: {objectLang}';
        } else if (isset($object['datatype']) && !empty($object['datatype'])) {
            $params['objectType'] = $object['datatype'];
            $objectProperties .= ', type: {objectType}';
        }
        $objectDefinition    = '(object {' . $objectProperties . '})';
        if ($subjectId === null && $objectId === null) {
            // Create completely new nodes and the required relation.
            $query = 'CREATE %s-%s->%s';
            $query = sprintf($query, $subjectDefinition, $predicateDefinition, $objectDefinition);
            $this->executeCypherQuery($query, $params);
            return;
        }
        // Reuse subject and/or object if possible.
        $startingPoints = array();
        if ($subjectId !== null) {
            $params['subjectId'] = $subjectId;
            $startingPoints[]    = 'subject=node({subjectId})';
            $subjectDefinition   = 'subject';
        }
        if ($objectId !== null) {
            $params['objectId'] = $objectId;
            $startingPoints[]   = 'object=node({objectId})';
            $objectDefinition   = 'object';
        }
        $query = 'START ' . implode(', ', $startingPoints)
               . 'CREATE UNIQUE %s-%s->%s';
        $query = sprintf($query, $subjectDefinition, $predicateDefinition, $objectDefinition);
        $this->executeCypherQuery($query, $params);
    }

    /**
     * Deletes all triples in the given graph that match the provided pattern.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_TriplePattern $pattern
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
            $params['objectValue'] = $object['value'];
            $params['objectType']  = $object['type'];
            if (isset($object['datatype']) && !empty($object['datatype'])) {
                $conditions[] = 'object.type! = {objectDataType}';
                $params['objectDataType'] = $object['datatype'];
            } else {
                $conditions[] = 'NOT(HAS(object.datatype))';
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
        $query .= 'DELETE r';
        $this->executeCypherQuery($query, $params);
    }

    /**
     * Removes all triples in the database.
     */
    public function clear()
    {
        $deletePredicates = 'START r=relationship(*) DELETE r';
        $this->executeCypherQuery($deletePredicates);
        $deleteNodes      = 'START n=node(*) DELETE n';
        $this->executeCypherQuery($deleteNodes);
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
        $query  = 'START n=node(*) MATCH (n)-[r]->() RETURN COUNT(r) AS numberOfTriples';
        $result = $this->executeCypherQuery($query);
        return $result[0]['numberOfTriples'];
    }

    /**
     * Executes the provided Cypher query and returns the results.
     *
     * @param string $query
     * @param array(string=>mixed) $params
     * @return \Everyman\Neo4j\Query\ResultSet
     */
    protected function executeCypherQuery($query, array $params = array())
    {
        $operation = new Query($this->apiClient, $query, $params);
        return $operation->getResultSet();
    }

}

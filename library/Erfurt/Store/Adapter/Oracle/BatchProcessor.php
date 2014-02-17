<?php

use Doctrine\DBAL\Connection;

/**
 * Helper class that processes quad inserts and updates as batch.
 *
 * It is up to the batch processor to choose the method that is most
 * suitable to store a given number of quads.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class Erfurt_Store_Adapter_Oracle_BatchProcessor
{

    /**
     * The connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Creates a batch processor that uses the provided database connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
        $common = array(
            'graphs'     => array(),
            'subjects'   => array(),
            'predicates' => array(),
            'objects'    => array()
        );
        $large = array();
        foreach ($quads as $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            $data = $this->toData($quad);
            if (strlen($data['object']) > 4000) {
                $large[] = $data;
            } else {
                $common['graphs'][]     = $data['graph'];
                $common['subjects'][]   = $data['subject'];
                $common['predicates'][] = $data['predicate'];
                $common['objects'][]    = $data['object'];
            }
        }
        if (count($common['graphs']) > 0) {
            $this->persistCommonQuads($common);
        }
        if (count($large) > 0) {
            $this->persistLargeQuads($large);
        }
    }

    /**
     * Persists common triples (literal objects with at most 4000 bytes).
     *
     * @param array(string=>array(string)) $quadParts
     */
    public function persistCommonQuads(array $quadParts)
    {
        $query = 'BEGIN ERFURT.ADD_TRIPLES(:graphs, :subjects, :predicates, :objects); END;';
        $statement = $this->connection->prepare($query);
        $statement->bindValue('graphs', $quadParts['graphs'], SQLT_CHR);
        $statement->bindValue('subjects', $quadParts['subjects'], SQLT_CHR);
        $statement->bindValue('predicates', $quadParts['predicates'], SQLT_CHR);
        $statement->bindValue('objects', $quadParts['objects'], SQLT_CHR);
        $statement->execute();
    }

    /**
     * Inserts triples with large literal objects (> 4000 bytes) into the database.
     *
     * @param array(array(string=>string)) $quads
     */
    protected function persistLargeQuads(array $quads)
    {
        $statement = $this->createInsertStatement(count($quads));
        foreach ($quads as $index => $quad) {
            /* @var $quad array(string=>string) */
            $statement->bindValue("modelAndGraph_$index", $quad['graph']);
            $statement->bindValue("subject_$index", $quad['subject']);
            $statement->bindValue("predicate_$index", $quad['predicate']);
            $statement->bindValue("object_$index", $quad['object'], PDO::PARAM_LOB);
        }
        $statement->execute();
    }

    /**
     * Prepares a statement that is used to insert the provided number of quads.
     *
     * The statement requires a set of parameters for each quad.
     * These parameter sets are numbered, starting at index 0:
     *
     * # modelAndGraph_{index} - Model name and graph IRI, separated by colon (":").
     * # subject_{index}       - Subject IRI.
     * # predicate_{index}     - Predicate IRI.
     * # object_{index}        - Encoded object.
     *
     * A set of parameters for all indexes from 0 to ($numberOfQuads - 1) must
     * be provided.
     *
     * IRIs must be enclosed by angle braces ("<", ">").
     * Objects must be IRIs or encoded literals, for example:
     *
     * # "literal"
     * # "literal"@de
     * # "literal"^^xsd:string
     *
     * @param integer $numberOfQuads The number of quads that will be inserted.
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function createInsertStatement($numberOfQuads)
    {
        $insertParts = array();
        for ($i = 0; $i < $numberOfQuads; $i++) {
            $lines = array(
                "  SELECT ",
                "    SDO_RDF_TRIPLE_S(",
                "      :modelAndGraph_$i,",
                "      :subject_$i,",
                "      :predicate_$i,",
                "      :object_$i",
                "     )",
                "  FROM DUAL"
            );
            $insertParts[] = implode(PHP_EOL, $lines);
        }
        $query = 'INSERT INTO erfurt_semantic_data (triple) ' . PHP_EOL
               . implode(PHP_EOL . ' UNION ALL ', $insertParts);
        return $this->connection->prepare($query);
    }

    /**
     * Converts the provided quad into encoded triple parts.
     *
     * The returned array has the following keys:
     *
     * - graph
     * - subject
     * - predicate
     * - object
     *
     * @param \Erfurt_Store_Adapter_Sparql_Quad $quad
     * @return array(string=>string)
     */
    protected function toData($quad)
    {
        $graph     = $this->getModelName() . ':<' . $quad->getGraph() . '>';
        $subject   = $quad->getSubject();
        $subject   = (strpos($subject, '_:') === 0) ? $subject : '<' . $subject . '>';
        $predicate = '<' . $quad->getPredicate() . '>';
        $object    = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::buildLiteralFromSpec(
            $quad->getObject()
        );
        return array(
            'graph'     => $graph,
            'subject'   => $subject,
            'predicate' => $predicate,
            'object'    => $object
        );
    }

    /**
     * Returns the name of the semantic model that is used.
     *
     * @return string
     */
    protected function getModelName()
    {
        return $this->connection->getUsername() . '_erfurt';
    }

}

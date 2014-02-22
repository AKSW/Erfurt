<?php

use Doctrine\DBAL\Connection;

/**
 * Batch processor that creates a single insert query to store quads.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 15.02.14
 */
class Erfurt_Store_Adapter_Oracle_CombinedInsertBatchProcessor implements Erfurt_Store_Adapter_Sparql_BatchProcessorInterface
{

    /**
     * The connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * List of insert statements that have already been prepared.
     *
     * The key is the number of quads that the statement is meant for.
     *
     * @var (integer=>\Doctrine\DBAL\Driver\Statement)
     */
    protected $insertStatements = array();

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
     * Stores the provided triples.
     *
     * @param array(\Erfurt_Store_Adapter_Sparql_Quad) $quads
     */
    public function persist(array $quads)
    {
        if (count($quads) === 0) {
            return;
        }
        $model     = $this->getModelName();
        $statement = $this->getInsertStatement(count($quads));
        foreach ($quads as $index => $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            //
            $statement->bindValue("modelAndGraph_$index", $model . ':<' . $quad->getGraph() . '>');

            $subject = $quad->getSubject();
            $subject = (strpos($subject, '_:') === 0) ? $subject : '<' . $subject . '>';
            $statement->bindValue("subject_$index", $subject);

            $statement->bindValue("predicate_$index", '<' . $quad->getPredicate() . '>');

            $object = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::buildLiteralFromSpec(
                $quad->getObject()
            );
            // Bind literal as a CLOB if it is too long.
            $type = (strlen($object) > 4000) ? PDO::PARAM_LOB : PDO::PARAM_STR;
            $statement->bindValue("object_$index", $object, $type);
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
    protected function getInsertStatement($numberOfQuads)
    {
        if (!isset($this->insertStatements[$numberOfQuads])) {
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
            $this->insertStatements[$numberOfQuads] = $this->connection->prepare($query);
        }
        return $this->insertStatements[$numberOfQuads];
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

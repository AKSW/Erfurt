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
     * A prepared insert statement or null if it was not created yet.
     *
     * @var \Doctrine\DBAL\Driver\Statement|null
     */
    protected $insertStatement = null;

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
        foreach ($quads as $quad) {
            /* @var $quad \Erfurt_Store_Adapter_Sparql_Quad */
            $subject = $quad->getSubject();
            $subject = (strpos($subject, '_:') === 0) ? $subject : '<' . $subject . '>';
            $params = array(
                'modelAndGraph' => $this->getModelName() . ':<' . $quad->getGraph() . '>',
                'subject'       => $subject,
                'predicate'     => '<' . $quad->getPredicate() . '>',
                'object'        => Erfurt_Store_Adapter_Oracle_ResultConverter_Util::buildLiteralFromSpec(
                    $quad->getObject()
                )
            );
            $statement = $this->getInsertStatement();
            if (strlen($params['object']) > 4000) {
                // Literal is too long, therefore, bind it as a CLOB.
                $largeLiteral = $params['object'];
                unset($params['object']);
                $statement->bindValue('object', $largeLiteral, PDO::PARAM_LOB);
            }
            $statement->execute($params);
        }
    }

    /**
     * Prepares a statement that is used to insert a triple.
     *
     * The statement requires the following parameters:
     *
     * # modelAndGraph - Model name and graph IRI, separated by colon (":").
     * # subject       - Subject IRI.
     * # predicate     - Predicate IRI.
     * # object        - Encoded object.
     *
     * IRI must be enclosed by angle braces ("<", ">").
     * Objects must be IRIs or encoded literals, for example:
     *
     * # "literal"
     * # "literal"@de
     * # "literal"^^xsd:string
     *
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function getInsertStatement()
    {
        if ($this->insertStatement === null) {
            $query = 'INSERT INTO erfurt_semantic_data (triple) '
                . 'VALUES ('
                . '  SDO_RDF_TRIPLE_S('
                . '    :modelAndGraph,'
                . '    :subject,'
                . '    :predicate,'
                . '    :object'
                . '  )'
                . ')';
            $this->insertStatement = $this->connection->prepare($query);
        }
        return $this->insertStatement;
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

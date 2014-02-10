<?php

use Doctrine\DBAL\Connection;

/**
 * Loads large literals by value ID.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Oracle_ClobLiteralLoader
{

    /**
     * The connection that is used to retrieve the literal data.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * The statement that is used to load the values.
     *
     * Contains null if the statement was not prepared yet.
     * Use getLoadStatement() to get a statement object.
     *
     * @var \Doctrine\DBAL\Driver\Statement|null
     */
    protected $loadStatement = null;

    /**
     * Creates a loader that uses the provided connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Loads the CLOB that is identified by the provided ID.
     *
     * @param integer $valueId
     * @return string|null
     */
    public function load($valueId)
    {
        $statement = $this->getLoadStatement();
        $statement->execute(array('valueId' => $valueId));
        $value = $statement->fetchColumn();
        // Return null if no value was found.
        // Return the text without double quotes ('"') otherwise,
        // but do not decode the data (Tabs etc.) as this is the
        // responsibility of a converter.
        return ($value === false) ? null : substr($value, 1, -1);
    }

    /**
     * Returns the statement that is used to load the CLOB value.
     *
     * The parameter "valueId" is required.
     *
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function getLoadStatement()
    {
        if ($this->loadStatement === null) {
            $query = 'SELECT d.triple.GET_OBJECT() '
                   . 'FROM erfurt_semantic_data d '
                   . 'WHERE d.triple.RDF_O_ID = :valueId';
            $this->loadStatement = $this->connection->prepare($query);
        }
        return $this->loadStatement;
    }

}

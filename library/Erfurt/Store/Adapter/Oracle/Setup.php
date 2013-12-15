<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

/**
 * Used to setup the Oracle Triple Store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 */
class Erfurt_Store_Adapter_Oracle_Setup
{

    /**
     * The database connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Creates a setup object that uses the provided connection to
     * install a Triple Store.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Checks if the Triple Store is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        // We assume that the Triple Store was installed if the data table already exists.
        return $this->getSchemaManager()->tablesExist(array('erfurt_semantic_data'));
    }

    /**
     * Installs the Triple Store.
     */
    public function install()
    {
        $dataTable = new Table(
            'erfurt_semantic_data',
            array(
                new Column('id', Type::getType(Type::INTEGER)),
                new Column('triple', Type::getType('sdo_rdf_triple_s'))
            ),
            array(
                new Index('id', array('id'), true, true)
            )
        );
        $this->getSchemaManager()->createTable($dataTable);
        $query  = 'EXECUTE SEM_APIS.CREATE_SEM_MODEL(:model, :dataTable, :tripleColumn)';
        $params = array(
            'model'        => 'erfurt',
            'dataTable'    => 'erfurt_semantic_data',
            'tripleColumn' => 'triple'
        );
        $this->connection->executeQuery($query, $params);
    }

    /**
     * Removes a previously installed Triple Store.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        $query  = 'EXECUTE SEM_APIS.DROP_SEM_MODEL(:model)';
        $params = array('model' => 'erfurt');
        $this->connection->executeQuery($query, $params);
        $this->getSchemaManager()->dropTable('erfurt_semantic_data');
    }

    /**
     * Returns the schema manager for the connection.
     *
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    protected function getSchemaManager()
    {
        if (!Type::hasType('sdo_rdf_triple_s')) {
            Type::addType('sdo_rdf_triple_s', '\Erfurt_Store_Adapter_Oracle_TripleType');
        }
        return $this->connection->getSchemaManager();
    }

}

<?php

use Doctrine\DBAL\Connection;

/**
 * Installs the semantic model that is necessary to store triples.
 *
 * The data table must exist before the model is installed.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Oracle_Setup_ModelSetup implements \Erfurt_Store_Adapter_Container_SetupInterface
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
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return $this->modelExists($this->getModelName());
    }

    /**
     * Installs the feature.
     */
    public function install()
    {
        $this->createModel();
    }

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        $this->dropModel();
    }

    /**
     * Creates the semantic model.
     */
    protected function createModel()
    {
        $query  = 'BEGIN SEM_APIS.CREATE_SEM_MODEL(:model, :dataTable, :tripleColumn); END;';
        $params = array(
            'model'        => $this->getModelName(),
            'dataTable'    => 'erfurt_semantic_data',
            'tripleColumn' => 'triple'
        );
        $this->connection->prepare($query)->execute($params);
    }

    /**
     * Removes the semantic model.
     *
     * @throws Doctrine\DBAL\DBALException|Exception
     */
    protected function dropModel()
    {
        $model = $this->getModelName();
        if ($this->modelExists($model)) {
            $query = 'BEGIN SEM_APIS.DROP_SEM_MODEL(:model); END;';
            $params = array('model' => $model);
            $this->connection->prepare($query)->execute($params);
        }
    }

    /**
     * Checks if the provided semantic model exists.
     *
     * @param string $model
     * @return boolean
     */
    protected function modelExists($model)
    {
        $query = 'SELECT m.MODEL_NAME FROM MDSYS.SEM_MODEL$ m '
               . 'WHERE OWNER=SYS_CONTEXT(:namespace, :parameter) AND '
               . 'MODEL_NAME=:modelName';
        $params = array(
            'namespace' => 'USERENV',
            'parameter' => 'CURRENT_USER',
            'modelName' => strtoupper($model)
        );
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($rows) > 0;
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

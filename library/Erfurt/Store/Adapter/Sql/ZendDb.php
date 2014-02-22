<?php

/**
 * SQL adapter for SQL databases via Zend DB.
 *
 * This class has been extracted from \Erfurt_Store_Adapter_EfZendDb
 * to ensure that the SQL adapter can be used in combination with (non-MySQL)
 * SPARQL adapters.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 22.02.14
 */
class Erfurt_Store_Adapter_Sql_ZendDb implements Erfurt_Store_Sql_Interface
{

    /**
     * The connection adapter.
     *
     * @var Zend_Db_Adapter_Abstract|boolean
     */
    protected $_dbConn = false;

    /**
     * Configuration options for the adapter.
     *
     * @var array(string=>mixed)
     */
    protected $_adapterOptions = array();

    /**
     * Constructor
     *
     * @param array $adapterOptions This adapter class needs the following parameters:
     *                  - 'host'
     *                  - 'username'
     *                  - 'password'
     *                  - 'dbname'
     */
    public function __construct($adapterOptions = array())
    {
        $adapterOptions = array_merge(array('host' =>  'localhost', 'profiler'  => false), $adapterOptions);
        $this->_adapterOptions = $adapterOptions;
        $this->_connect();
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function createTable($tableName, array $columns)
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            return $this->_createTableMysql($tableName, $columns);
        }
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function lastInsertId()
    {
        return $this->_dbConn->lastInsertId();
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function listTables($prefix = '')
    {
        return $this->_dbConn->listTables();
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        $start = microtime(true);

        // add limit/offset
        if ($limit < PHP_INT_MAX) {
            $sqlQuery = sprintf('%s LIMIT %d OFFSET %d', (string)$sqlQuery, (int)$limit, (int)$offset);
        }

        $queryType = strtolower(substr($sqlQuery, 0, 6));
        if ($queryType === 'insert' ||
            $queryType === 'update' ||
            $queryType === 'create' ||
            $queryType === 'delete'
        ) {
            // Handle without ZendDb
            if ($this->_adapterOptions['dbtype'] == 'sqlsrv') {
                $result = $this->_dbConn->query($sqlQuery);
            } else {
                $result = $this->_dbConn->getConnection()->query($sqlQuery);
            }


            if ($result !== true) {
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception(
                    'SQL query failed: ' .
                    $this->_dbConn->getConnection()->error
                );
            }
        } else {
            try {
                $result = @$this->_dbConn->fetchAll($sqlQuery);
            } catch (Zend_Db_Exception $e) { #return false;
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception(
                    $e->getMessage()
                );
            }
        }

        // Debug executed SQL queries in debug mode (7)
        $logger = Erfurt_App::getInstance()->getLog();
        $time = (microtime(true) - $start) * 1000;
        $debugText = 'SQL Query (' . $time . ' ms)';
        $logger->debug($debugText);

        return $result;
    }

    /**
     * For Zend_Db does not abstract SQL statements that can't be prepared, we need to do this by hand
     * for each supported db server, which can be used with the ZendDb adapter.
     */
    protected function _createTableMysql($tableName, array $columns)
    {
        $createTable = 'CREATE TABLE `' . (string)$tableName . '` (';

        $i = 0;
        foreach ($columns as $columnName => $columnSpec) {
            $createTable .= PHP_EOL
                . '`' . $columnName . '` '
                . $columnSpec . (($i < count($columns) - 1) ? ',' : '');
            ++$i;
        }
        $createTable .= PHP_EOL
            . ')';
        $success = $this->_dbConn->getConnection()->query($createTable);

        if (!$success) {
            // TODO dedicated exception
            throw new Exception('Could not create database table with name ' . $tableName . '.');
        } else {
            return $success;
        }
    }

    protected function _connect()
    {
        switch (strtolower($this->_adapterOptions['dbtype'])) {
            case 'mysql':
                if (extension_loaded('mysqli')) {
                    require_once 'Zend/Db/Adapter/Mysqli.php';
                    $this->_dbConn = new Zend_Db_Adapter_Mysqli($this->_adapterOptions);
                } else if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
                    require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
                    $this->_dbConn = new Zend_Db_Adapter_Pdo_Mysql($this->_adapterOptions);
                } else {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('Neither "mysqli" nor "pdo_mysql" extension found.', -1);
                }
                break;
            case 'sqlsrv':
                if (extension_loaded('sqlsrv')) {
                    require_once 'Zend/Db/Adapter/Sqlsrv.php';
                    $this->_dbConn = new Zend_Db_Adapter_Sqlsrv($this->_adapterOptions);
                } else {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('Sqlsrv extension not found.', -1);
                }
                break;
            default:
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Given database adapter is not supported.', -1);
        }

        try {
            // try to initialize the connection
            $this->_dbConn->getConnection();
        } catch (Zend_Db_Adapter_Exception $e) {
            // maybe wrong login credentials or db-server not running?!
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception(
                'Could not connect to database with name: "' . $this->_adapterOptions['dbname'] .
                '". Please check your credentials and whether the database exists and the server is running.', -1
            );

        } catch (Zend_Exception $e) {
            // maybe a needed php extension is not loaded?!
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('An error with the specified database adapter occured.', -1);
        }

        // we want indexed results
        //$this->_dbConn->setFetchMode(Zend_Db::FETCH_NUM);
    }

    /**
     * save all but except the db connection
     * @return array keys to save
     */
    function __sleep()
    {
        $vars = get_object_vars($this);
        unset($vars['_dbConn']);
        return array_keys($vars);
    }

    function __wakeUp()
    {
        $this->_connect();
    }

}

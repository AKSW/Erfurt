<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Abstraction for worker jobs.
 *
 * @category Erfurt
 * @package  Erfurt_Worker_Job
 * @author   Christian Würker <christian.wuerker@ceusmedia.de>
 * @author   Sebastian Tramp <mail@sebastian.tramp.name>
 */
abstract class Erfurt_Worker_Job_Abstract
{

    const LOG_SUCCESS   = 1;
    const LOG_FAILURE   = 2;
    const LOG_EXCEPTION = 4;

    /**
     * private values can be retrieved by jobs with the same name id only
     */
    const SCOPE_PRIVATE = 1;
    /**
     * scope class values can be retrieved by jobs with the same class
     */
    const SCOPE_CLASS   = 2;
    /**
     * scope global values can be retrieved by all jobs
     */
    const SCOPE_GLOBAL  = 3;

    const KEY_EXPRESSION = '/^[a-zA-Z0-9]+$/';

    const CACHEID_PREFIX = 'JobKey_';

    public    $logWriter = array();
    protected $options;
    protected $name;

    /**
     *  Constructor.
     *
     *  @param string $name    the jobs name
     *  @param array  $options Map of job settings
     *
     *  @access     public
     *  @return     void
     */
    public function __construct($name, $options = array())
    {
        $this->name     = $name;
        $this->options  = $options;
        $this->configureLogWriter(
            'Stream',
            array('url' => 'logs/worker.server.log')
        );
        $this->__init();
    }

    /**
     *  Override this method to handle constructions of needed resources in your job class.
     *
     *  @access     protected
     *  @return     void;
     */
    protected function __init()
    {
    }

    /**
     *  get the name of the job instance (unique for the worker)
     *
     *  @return string
     *
     *  @access     public
     */
    public function getName()
    {
        if (!empty($this->name)) {
            return $this->name;
        } else {
            throw new Erfurt_Worker_Exception(
                'The jobs name is not available.'
            );
        }
    }

    /**
     *  Set parameters for log writer.
     *
     *  @param string      $writerName     Name of writer backend
     *  @param null|array  $writerParams   Parameters of writer backend
     *  @param null|string $filterName     Name of filter
     *  @param null|array  $filterParams   Parameters of filter
     *
     *  @access     public
     *  @see        http://framework.zend.com/manual/1.8/en/zend.log.writers.html
     */
    public function configureLogWriter($writerName, $writerParams = null, $filterName = null, $filterParams = null)
    {
        $config = array();
        if ($writerName !== null) {
            $config['writerName']   = $writerName;
            if ($writerParams !== null) {
                $config['writerParams']   = $writerParams;
            }
            if ($filterName !== null) {
                $config['filterName']   = $filterName;
                $config['filterParams']   = $filterParams;
            }
            $this->logWriter    = $config;
        }
    }

    /**
     *  Writes messages of several levels into configured log.
     *
     *  @param string  $message Message to write into log
     *  @param integer $level   Level of log entry
     *
     *  @access public
     *  @return void
     */
    protected function log($message, $level)
    {
        $class   = get_class($this);
        $message = $class .' ('. $this->name .') '. $message;
        $logger = Zend_Log::factory(array($this->logWriter));
        $logger->addPriority('SUC', 8);
        switch($level) {
            case self::LOG_SUCCESS:
                $logger->log($message, 8);
                break;
            case self::LOG_FAILURE:
                $logger->log($message, 3);
                break;
            case self::LOG_EXCEPTION:
                $logger->log($message, 0);
                break;
        }
    }

    protected function logSuccess($message)
    {
        $this->log($message, self::LOG_SUCCESS);
    }

    protected function logException($message)
    {
        $this->log($message, self::LOG_EXCEPTION);
    }

    protected function logFailure($message)
    {
        $this->log($message, self::LOG_FAILURE);
    }

    /**
     *  Implement this method in your job class.
     *
     *  @param mixed $workload the jobs workload
     *
     *  @access     public
     *  @return     void
     *  @abstract
     */
    public abstract function run($workload);

    /**
     *  Calls job main method and logs possibly caught exception.
     *
     *  @param GearmanJob $job the job object
     *
     *  @access public
     *  @return boolean
     */
    public function work(GearmanJob $job)
    {
        try{
            $workload   = json_decode($job->workload());
            $this->run($workload);
            return true;
        }
        catch(Exception $e){
            $this->logException($e->getMessage());
            return false;
        }
    }

    /**
     *  get a value from a job persistent key/value store
     *
     *  @param string $key   the key
     *  @param int    $scope the scope of the store
     *
     *  @return mixed or false if there is no value for the key
     *  @todo this should be cache independend
     */
    protected function getValue($key, $scope = self::SCOPE_PRIVATE)
    {
        $keyId = $this->_getCacheIdForKeyAndScope($key, $scope);

        // try to load the cached value
        $objectCache = OntoWiki::getInstance()->erfurt->getCache();
        $theValue    = $objectCache->load($keyId);
        return $theValue;
    }

    /**
     *  set a value from a job persistent key/value store
     *
     *  @param string $value the value to save
     *  @param string $key   the key
     *  @param int    $scope the scope of the store
     *
     *  @return void
     *  @todo this should be cache independend
     */
    protected function setValue($value, $key, $scope = self::SCOPE_PRIVATE)
    {
        $keyId = $this->_getCacheIdForKeyAndScope($key, $scope);
        $objectCache = OntoWiki::getInstance()->erfurt->getCache();
        $objectCache->save($value, $keyId);
    }

    /**
     *  returns a cacheId for a key and a scope
     *
     *  @param string $key   the key
     *  @param int    $scope the scope of the store
     *
     *  @return string
     */
    private function _getCacheIdForKeyAndScope($key, $scope)
    {
        if (preg_match (self::KEY_EXPRESSION, (string)$key) !== 1) {
            throw new Erfurt_Worker_Exception(
                'The key does not match the expression ' . self::KEY_EXPRESSION
            );
        }
        if ($scope == self::SCOPE_PRIVATE) {
            $cacheId = self::CACHEID_PREFIX . $this->name . '_' . $key;
        } else if ($scope == self::SCOPE_CLASS) {
            $cacheId = self::CACHEID_PREFIX . get_class($this) . '_' . $key;
        } else if ($scope == self::SCOPE_GLOBAL) {
            $cacheId = self::CACHEID_PREFIX . $key;
        }
        //$this->logSuccess('uses cache id '$cacheId);
        return $cacheId;
    }

}

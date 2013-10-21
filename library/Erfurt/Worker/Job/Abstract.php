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
 * @package Erfurt
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
abstract class Erfurt_Worker_Job_Abstract{

    const LOG_SUCCESS   = 1;
    const LOG_FAILURE   = 2;
    const LOG_EXCEPTION = 4;

    public $defaultLogFile  = "logs/worker.server.log";
    protected $logWriter;
    protected $options;

    /**
     *  Constructor.
     *  @access     public
     *  @param      array       $options        Map of job settings
     *  @return     void
     */
    public function __construct($options = array()){
        $this->options  = $options;
        $this->__init();
    }

    protected function log($message, $level){
        if(!$this->logWriter){
            $this->logWriter    = new Zend_Log_Writer_Stream($this->defaultLogFile);
        }
        $log    = new Zend_Log($this->logWriter);
        $logger->addPriority('SUCC', 8);
        switch($level){
            case self::LOG_SUCCESS:
                $log->info($message, 8);
                break;
            case self::LOG_FAILURE:
                $log->log($message, 3);
                break;
            case self::LOG_EXCEPTION:
                $log->log($message, 0);
                break;
        }
    }

    protected function logSuccess($message){
        $this->log($message, self::LOG_SUCCESS);
    }

    protected function logException($message){
        $this->log($message, self::LOG_EXCEPTION);
    }

    protected function logFailure($message){
        $this->log($message, self::LOG_FAILURE);
    }

    public abstract function run($workload);

    public function setLogWriter(Zend_Log_Writer_Abstract $logWriter){
        $this->logWriter    = $logWriter;
    }

    public function work(GearmanJob $job){
        try{
            $workload   = json_decode($job->workload());
            $this->run($workload);
            return TRUE;
        }
        catch(Exception $e){
            $this->logException($e->getMessage());
            return FALSE;
        }
    }
}

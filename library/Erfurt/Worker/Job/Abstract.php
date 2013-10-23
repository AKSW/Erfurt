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

    public $logWriter    = array();
    protected $options;

    /**
     *  Constructor.
     *  @access     public
     *  @param      array       $options        Map of job settings
     *  @return     void
     */
    public function __construct($options = array()){
        $this->options  = $options;
        $this->configureLogWriter("Stream", array(
            'url'   => "logs/worker.server.log"
        ));
        $this->__init();
    }

    /**
     *  Set parameters for log writer.
     *  @access     public
     *  @param      string      $writerName     Name of writer backend)
     *  @param      null|array  $writerParams   Parameters of writer backend
     *  @param      null|string $filterName     Name of filter
     *  @param      null|array  $filterParams   Parameters of filter
     *  @see        http://framework.zend.com/manual/1.8/en/zend.log.writers.html
     */
    public function configureLogWriter($writerName, $writerParams = NULL, $filterName = NULL, $filterParams = NULL){
        $config = array();
        if($writerName !== NULL){
            $config['writerName']   = $writerName;
            if($writerParams !== NULL){
                $config['writerParams']   = $writerParams;
            }
            if($filterName !== NULL){
                $config['filterName']   = $filterName;
                $config['filterParams']   = $filterParams;
            }
           $this->logWriter    = $config;
        }
    }

    /**
     *  Writes messages of several levels into configured log.
     *  @access     public
     *  @param      string      $message        Message to write into log
     *  @param      integer     $level          Level of log entry
     */
    protected function log($message, $level){
        $logger    = Zend_Log::factory(array($this->logWriter));
        $logger->addPriority('SUCC', 8);
        switch($level){
            case self::LOG_SUCCESS:
                $logger->info($message, 8);
                break;
            case self::LOG_FAILURE:
                $logger->log($message, 3);
                break;
            case self::LOG_EXCEPTION:
                $logger->log($message, 0);
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

    /**
     *  Implement this method in your job class.
     *  @abstract
     *  @access     public
     *  @param      mixed       $workload
     *  @return     void
     */
    public abstract function run($workload);

    /**
     *  Calls job main method and logs possibly caught exception.
     *  @access     public
     *  @param      GearmanJob  $job
     *  @return     boolean
     */
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

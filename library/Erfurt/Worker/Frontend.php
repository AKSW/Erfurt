<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Frontend class (worker client) for worker jobs.
 *
 * @category Erfurt
 * @package  Erfurt_Worker
 * @author   Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Worker_Frontend
{
    static public $backends = array(
        'gearman'
    );

    /**
     *  Indicates whether frontend is fully configured and ready to use.
     *  @var    boolean
     */
    protected $configured   = FALSE;

    /**
     *  Indicates whether frontend is enabled to use or not.
     *  @var    boolean
     */
    protected $enabled      = TRUE;

    /**
     *  Protected singleton instance of worker frontend.
     *  @static
     *  @var    array
     */
    static protected $instance;

    /**
     *  Job handle of latest called (async) job.
     *  @var    string
     */
    protected $lastJobHandle;

    /**
     *  Construction is not allowed.
     *  Please use getInstance() instead.
.    *  @access     protected
     *  @return     void
     */
    protected function __construct()
    {
        $this->client       = new GearmanClient();
        $this->configured   = FALSE;
    }

    /**
     *  Cloning is not allowed.
.    *  @access     protected
     *  @return     void
     */
    protected function __clone()
    {
    }
    
    
    /**
     *  Calls synchronous execution of an registrered worker job and send workload "ping" to it.
     *  Returns the answer of the worker job.
     *  Implemented to have a way to test via client if the necessary job server is still running.
     *  @access public
     *  @param  string  $jobName
     *  @param  integer $timeout time to wait for an answer (in micro seconds)
     *  @return mixed   returned data from the worker job
     */
    public function ping($jobName, $timeout = 5000)
    {
        $currentTimeout = $this->client->timeout(); // save currently used timeout value
        $this->client->setTimeout($timeout); // set new timeout
        $pingreturn = $this->client->doHigh($jobName, '"ping"');
        $this->client->setTimeout($currentTimeout); // set timeout back to old value
        $this->testSuccessOfJobCall($this->client);
        
        return $pingreturn;
    }

    /**
     *  Calls for asynchronous or synchronous execution of an registrered worker job.
     *  @access public
     *  @param  string  $jobName
     *  @param  mixed   $workload Workload for job, may be empy
     *  @param  integer $priority Flag: priority of execution, 1: high, 0: normal, -1: low, default: normal
     *  @param  integer $mode     Flag: mode of execution, 0: asynchronous, 1: synchronous, default: asynchronous
     *  @return void
     */
    public function call($jobName, $workload = NULL, $priority = 0, $mode = 0)
    {
        if($this->isEnabled()){
            if ((int)$mode === 0) {
                $this->callAsync($jobName, $workload, $priority);
            } else if ((int)$mode === 1) {
                $this->callSync($jobName, $workload, $priority);
            }
        }
    }

    /**
     *  Calls for asynchronous execution of an registrered worker job.
     *  This method only allows asynchronous job execution. Use call() for synchronous job execution.
     *  @access public
     *  @param  string  $jobName
     *  @param  mixed   $workload  Workload for job, may be empy
     *  @param  integer $priority  Flag: priority of execution, 1: high, 0: normal, -1: low, default: normal
     *  @return string  Job handle assigned by the Gearman server
     */
    public function callAsync( $jobName, $workload = NULL, $priority = 0 )
    {
        $method = "doBackground";
        if ($priority === 1) {
            $method = "doHighBackground";
        } else if ($priority === -1) {
            $method = "doLowBackground";
        }
        $workload = $this->prepareWorkload($workload);
        $this->lastJobHandle = $this->client->$method($jobName, $workload);
        $this->testSuccessOfJobCall($this->client);
    }

    /**
     *  Calls for synchronous execution of an registrered worker job.
     *  This method only allows synchronous job execution. Use callAsync() for asynchronous job execution.
     *  @access public
     *  @param  string  $jobName
     *  @param  mixed   $workload  Workload for job, may be empy
     *  @param  integer $priority  Flag: priority of execution, 1: high, 0: normal, -1: low, default: normal
     *  @return void
     */
    public function callSync($jobName, $workload = NULL, $priority = 0)
    {
        $method = "doNormal";
        if ($priority === 1) {
            $method = "doHigh";
        } else if ($priority === -1) {
            $method = "doLow";
        }
        $workload = $this->prepareWorkload($workload);
        $this->client->$method($jobName, $workload);
        $this->testSuccessOfJobCall($this->client);
    }
    
    /**
     *  Test return code of Gearman Client after job call and trigger error it is not the success code.
     *  @access public
     *  @param  object  $client             Gearman Client    
     *  @throws Erfurt_Worker_Exception     if return code is not GEARMAN_SUCCESS
     *  @return void
     */
    public function testSuccessOfJobCall($client = null)
    {
        if (!$client) {
            $client = $this->client;
        }
        
        $allowedReturnCodes = array(
            GEARMAN_SUCCESS
        );
        
        if (!in_array($client->returnCode(), $allowedReturnCodes)) {
            throw new Erfurt_Worker_Exception(
                'Job call failed. ' .
                $client->error() .
                ' [Code: ' . $client->returnCode() . ']',
                $client->returnCode()
            );
        }
        
    }

    /**
     *  Returns singleton instance of registry.
     *  @static
     *  @access     public
     *  @return     Erfurt_Worker_Frontend      Singleton instance of worker frontend
     *  @throws     RuntimeException            if worker is not configured
     *  @throws     RuntimeException            if worker is not enabled
     */
    static public function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *  Returns handle of latest called asynchronous job.
     *  @access     public
     *  @return     string      ASync: Job handle assigned by the Gearman server
     */
    public function getLastJobHandle()
    {
        return $this->lastJobHandle;
    }

    /**
     *  Indicates whether a asynchronous job is still running.
     *  @access     public
     *  @param      string      $jobHandle      Job handle assigned by the Gearman server
     *  @return     boolean
     */
    public function isStillRunning($jobHandle = NULL)
    {
        if ($jobHandle === NULL) {
            $jobHandle  = $this->getLastJobHandle();
            if ($jobHandle === NULL)
                throw new InvalidArgumentException(
                    'No job handle given'
                );
        }
        $status = $this->client->jobStatus($jobHandle);
        return $status[0];
    }

    /**
     *  Prepares workload for job call by serializing if not string or integer.
     *  @access     public
     *  @param      mixed       $workload       Workload to be prepared for job call
     *  @return     string      String presentation of workload
     */
    protected function prepareWorkload($workload)
    {
        switch(strtolower(gettype($workload))){
            case "array":
            case "object":
                $workload   = json_encode($workload);
                break;
        }
        return $workload;
    }

    public function isEnabled(){
        if(!$this->configured){
            throw new RuntimeException(
                'Worker frontend is not fully configured'
            );
        }
        return (boolean)$this->enabled;
    }

    public function setBackend($backend){
        $backend    = strtolower(trim($backend));
        if(!in_array($backend, self::$backends)){
            throw new InvalidArgumentException(
                'Backend "'.$backend.'" not supported'
            );
        }
        $this->backend  = $backend;
    }

    public function setServers($servers){
        $this->client->addServers($servers);
        $this->configured   = TRUE;
    }
}

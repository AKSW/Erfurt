<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Singleton registry class for job workers.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Worker_Registry{

    /**
     *  Map of default job options.
     *  @static
     *  @var    array
     */
    static $defaultJobOptions   = array();

    /**
     *  Protected singleton instance of registry.
     *  @static
     *  @var    array
     */
    static protected $instance;

    /**
     *  List of registered jobs.
     *  @var type 
     */
    protected $jobs				= array();

    /**
     *  Construction is not allowed.
     *  Please use getInstance() instead.
.    *  @access     protected
     *  @return     void
     */
    protected function __construct()
    {
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
     *  Add a job container to the registry.
     *  @access     public
     *  @param      Erfurt_Worker_Job_Container     $job        Job container instance
     *  @return     void
     */
    public function addJob( Erfurt_Worker_Job_Container $job )
    {
        $this->jobs[]   = $job;
    }

    /**
     *  Returns singleton instance of registry.
     *  @static
     *  @access     public
     *  @return     Erfurt_Worker_Registry     Singleton instance of registry 
     */
    static public function getInstance()
    {
        if( !self::$instance ){
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     *  Returns a list of registered work jobs.
     *  @access     public
     *  @return     array       List of registered jobs
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     *  Register a new worker job by its properties.
     *  @access     public
     *  @param      string      $name           Key name of worker job
     *  @param      string      $classFile      File name of job class
     *  @param      string      $className      Class name of job class
     *  @param      string      $options        Map of job options
     *  @return     void
     */
    public function registerJob( $name, $classFile, $className, $options = array() )
    {
        $options    = array_merge( self::$defaultJobOptions, $options );
        $job        = new Erfurt_Worker_Job_Container(
            $name,
            $classFile,
            $className,
            $options
        );
        $this->addJob( $job );
    }
}

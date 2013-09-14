<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Backend class for worker jobs.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Worker_Backend
{
    /**
     * Registry for existing jobs.
     *
     * @var Erfurt_Worker_Registry
     */
    protected $registry;

    /**
     * The constructor of this class.
     *
     */
    public function __construct( Erfurt_Worker_Registry $registry )
    {
        $this->registry = $registry;
    }

    /**
     *  Loads classes of all registered worker jobs and starts listening for job calls.
     *  This method keeps listening and will neither end nor return something.
     *  @access     public
     *  @return     void
     *  @throws     Erfurt_Worker_Exception if file of registered worker job is not existing
     *  @throws     Erfurt_Worker_Exception if class of registered worker job is not existing
     */
    public function listen()
    {
        $worker = new GearmanWorker();
        $worker->addServer();
        foreach( $this->registry->getJobs() as $job ){
            if( !file_exists( "../".$job->classFile ) ){
                throw new Erfurt_Worker_Exception(
                    "Class file of worker job '".$job->className."' is not existing"
                );
            }
            require_once "../".$job->classFile;
            if( !class_exists( $job->className ) ){
                throw new Erfurt_Worker_Exception(
                    "Worker job class '".$job->className."' is not existing"
                );
            }
            $object     = new $job->className;
            $callback   = array( $object, "run" );
            $worker->addFunction( $job->name, $callback );
        }
        while( $worker->work() );
    }
}

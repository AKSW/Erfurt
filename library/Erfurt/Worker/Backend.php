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
 * @package  Erfurt_Worker
 * @author   Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Worker_Backend
{
    /**
     *  @var Erfurt_Worker_Registry Registry for existing jobs
     */
    protected $registry;

    /**
     *  The constructor of this class.
     *  @access     public
     *  @param      Erfurt_Worker_Registry  Worker registry instance
     *  @return     void
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
        foreach ($this->registry->getJobs() as $job) {
            if (!file_exists("../".$job->classFile)) {
                throw new Erfurt_Worker_Exception(
                    "Class file of worker job '".$job->className."' is not existing"
                );
            }
            require_once "../".$job->classFile;
            if (!class_exists($job->className)) {
                throw new Erfurt_Worker_Exception(
                    "Worker job class '".$job->className."' is not existing"
                );
            }
            print('- '.$job->className." (".$job->classFile.")\n");

            $object     = new $job->className($job->config);
            $callback   = array($object, "run");
            $worker->addFunction($job->name, $callback, $job->options);
            print("Waiting for job calls now...\n");
        }
        while( $worker->work() );
    }
}

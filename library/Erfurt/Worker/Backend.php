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
     *  @var GearmanWorker instance
     */
    protected $worker;

    /**
     *  The constructor of this class.
     *
     *  @param Erfurt_Worker_Registry $registry Worker registry instance
     *
     *  @return     void
     *  @access     public
     */
    public function __construct(Erfurt_Worker_Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     *  Loads classes of all registered worker jobs and starts listening for job calls.
     *  This method keeps listening and will neither end nor return something.
     *
     *  @return     void
     *
     *  @throws     Erfurt_Worker_Exception if file of registered worker job is not existing
     *  @throws     Erfurt_Worker_Exception if class of registered worker job is not existing
     *  @access     public
     */
    public function listen()
    {
        $this->worker = new GearmanWorker();

        try {
            $this->worker->addServer();
        } catch (Exception $e) {
            $message = $e->getMessage();
            print('Exception: '. $message . PHP_EOL);
            print('Is gearmand running?' . PHP_EOL);
            exit;
        }

        foreach ($this->registry->getJobs() as $job) {
            $requiredClassFile = ONTOWIKI_ROOT . $job->classFile;

            if (!file_exists($requiredClassFile)) {
                throw new Erfurt_Worker_Exception(
                    'Class file of worker job "' . $job->className . '" is not existing'
                );
            }
            require_once $requiredClassFile;
            if (!class_exists($job->className)) {
                throw new Erfurt_Worker_Exception(
                    'Worker job class "' . $job->className . '" is not existing'
                );
            }
            print('- ' . $job->name . " (Class: " . $job->className . " | File: " . $job->classFile . ")" . PHP_EOL);

            $object     = new $job->className($job->name, $job->options);
            $callback   = array($object, "work");
            $this->worker->addFunction($job->name, $callback, $job->context);
        }
        print("Waiting for job calls now..." . PHP_EOL);
        $this->run();
    }

    protected function run()
    {
        try{
            while ($this->worker->work());
        }
        catch( Exception $e ){
            print("Exception: " . $e->getMessage() . PHP_EOL);
            $this->run();
        }
    }
}

<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Test Job for Worker
 *
 * @category Erfurt
 * @package  Erfurt_Worker
 */
class Erfurt_Worker_TestJob implements Erfurt_Worker_Job_Interface {

    public function __construct($config = NULL)
    {
        $this->_owApp           = OntoWiki::getInstance();
        $this->_config          = $this->_owApp->config;
    }

    public function run(GearmanJob $job){
        print ('Erfurt_Worker_TestJob started' . PHP_EOL);
    }
}

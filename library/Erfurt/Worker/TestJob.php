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
class Erfurt_Worker_TestJob extends Erfurt_Worker_Job_Abstract
{
    public function run($workload){
        print ('Erfurt_Worker_TestJob started' . PHP_EOL);
        $this->logSuccess('Erfurt_Worker_TestJob started');
    }
}

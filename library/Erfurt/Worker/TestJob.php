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
    public function run($load) {
        if (empty($load)) {
            $this->logSuccess('Erfurt_Worker_TestJob started (without workload)');
        } else {
            if (!empty($load->repeat) && (int)$load->repeat > 0) {
                $repeat = $load->repeat;
                $this->logSuccess("Erfurt_Worker_TestJob started ('$repeat' to go)");
                OntoWiki::getInstance()->callJob(
                    'test',
                    array('repeat' => $repeat-1)
                );
            } else {
                $this->logSuccess('Erfurt_Worker_TestJob started');
            }
        }
    }
}

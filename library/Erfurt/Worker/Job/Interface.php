<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Interface for worker jobs.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
interface Erfurt_Worker_Job_Interface
{
    /**
     *  Job execution method.
     *  This method is to be implemented to create real worker job classes.
     *  @access     public
     *  @param      GearmanJob      $job        Internal job object attached to worker backend
     */
    public function run( GearmanJob $job );
}

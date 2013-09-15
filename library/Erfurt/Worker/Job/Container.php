<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Data container for each defined job.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Worker_Job_Container
{
    /**
     *  Key name of job
     *  @var type 
     */
    public $name;

    /**
     *  Name of file containing worker job class.
     *  @var type 
     */
    public $classFile;

    /**
     *  Name of worker job class.
     *  @var type 
     */
    public $className;

    /**
     *  Map of options for worker job.
     *  @var type 
     */
    public $options     = array();

    /**
     *  Constructor.
     *  @access     public
     *  @param      string      $name           Key name of worker job
     *  @param      string      $classFile      File name of job class
     *  @param      string      $className      Class name of job class
     *  @param      string      $options        Map of job options
     *  @return     void
     */
    public function __construct( $name, $classFile, $className, $options = array() )
    {
        $this->name         = $name;
        $this->classFile    = $classFile;
        $this->className    = $className;
        $this->options      = $options;
    }
}


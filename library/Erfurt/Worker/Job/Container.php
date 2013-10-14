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
     *  @var string Key name of job
     */
    public $name;

    /**
     *  @var string Name of file containing worker job class
     */
    public $classFile;

    /**
     *  @var string Name of worker job class
     */
    public $className;

    /**
     *  @var Zend_Config Extension configuration
     */
    public $config     = array();

    /**
     *  @var type Map of options for worker job
     */
    public $options     = array();

    /**
     *  Constructor.
     *  @access     public
     *  @param      string      $name           Key name of worker job
     *  @param      string      $classFile      File name of job class
     *  @param      string      $className      Class name of job class
     *  @param      Zend_Config $config         Extension configuration
     *  @param      string      $options        Map of job options
     *  @return     void
     */
    public function __construct( $name, $classFile, $className, $config = NULL, $options = array() )
    {
        $this->name         = $name;
        $this->classFile    = $classFile;
        $this->className    = $className;
        $this->config       = $config;
        $this->options      = $options;
    }
}

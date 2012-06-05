<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt plug-in base class.
 * Sets up the environment for an erfurt plug-in.
 *
 * @package Erfurt
 * @author Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Plugin
{
    /**
     * Plug-in private config
     * @var Zend_Config
     */
    protected $_privateConfig = null;

    /**
     * Plug-in root directory
     * @var string
     */
    protected $_pluginRoot = null;

    /**
     * Constructor
     */
    public function __construct($root, $config = null)
    {
        $this->_pluginRoot = $root;

        if ($config instanceof Zend_Config) {
            $this->_privateConfig = $config;
        }

        $this->init();
    }

    /**
     * Customized plug-in initialization method
     */
    public function init()
    {
    }
}


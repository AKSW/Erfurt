<?php

/**
 * Erfurt plug-in base class.
 * Sets up the environment for an erfurt plug-in.
 *
 * @author Norman Heino <norman.heino@gmail.com>
 * @version $Id$
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


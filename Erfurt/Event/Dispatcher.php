<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Dispatcher.php 4015 2009-08-13 14:52:51Z pfrischmuth $
 */

require_once 'Erfurt/Event.php';

/**
 * Erfurt event dispatcher.
 *
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage event
 * @version    $$
 * @author     Michael Haschke
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Event_Dispatcher
{
    /** 
     * @var string 
     */
    const INIT_VALUE = '__init_value';
    
    /**
     * Handler priority if none is given
     * @var int
     */
    const DEFAULT_PRIORITY = 10;
    
    /** 
     * @var Zend_Logger 
     */
    protected $_logger = null;
    
    /** 
     * @var Erfurt_Event_Dispatcher 
     */
    private static $_instance = null;
    
    /** 
     * @var array 
     */
    private $_handlerInstances = array();
    
    /** 
     * @var array 
     */
    private $_registeredEvents = array();
    
    /**
     * Singleton instance
     *
     * @return Erfurt_Event_Dispatcher
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    /**
     * Binds an event handler (class or object) to a specified event.
     *
     * The handler can be an object that handles the event via a similarly 
     * called method or an array. In case of an array, the following keys must
     * be set: 
     * - class_name: the name of the handler class
     * - include_path: path where the class' implementation file can be found
     * - method_name: optional. specifies the method that handles the event.
     *                Same as the event name by default.
     *
     * @param string $eventName
     * @param object|array $handler
     */
    public function register($eventName, $handler, $priority = self::DEFAULT_PRIORITY)
    {
        // create event if not already handled
        if (!array_key_exists($eventName, $this->_registeredEvents)) {
            $this->_registeredEvents[$eventName] = array();
        }
        
        if (is_object($handler)) {
            // simply store handling object
            $this->_registerHandler($eventName, $handler, $priority);
            $this->_logger->info('Erfurt_Event_Dispatcher: ' . get_class($handler) . " registered for event '$eventName'");
        } else if (is_array($handler)) {
            // or check mandatory parameters
            if (!array_key_exists('class_name', $handler)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception("Missing key 'class_name' for handler registration.");
            }
            
            if (!array_key_exists('include_path', $handler)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception("Missing key 'include_path' for handler registration.");
            }
            
            // and add handler class info
            $this->_registerHandler($eventName, $handler, $priority);
            $this->_logger->info('Erfurt_Event_Dispatcher: ' . $handler['class_name'] . " registered for event '$eventName'");
        }
        // var_dump($this->_registeredEvents);
        
        return $this;
    }
    
    /**
     * Triggers the specified event, thereby invoking all registered observers.
     *
     * @param string $eventName
     * @param event parameters
     */
    public function trigger(Erfurt_Event $event)
    {
        $eventName = $event->getName();
        $result = self::INIT_VALUE;

        if (array_key_exists($eventName, $this->_registeredEvents)) {
            ksort($this->_registeredEvents[$eventName]);            
            foreach ($this->_registeredEvents[$eventName] as &$handler) {
                if (is_array($handler)) {
                    // handler is already instantiated
                    if (isset($handler['instance']) && is_object($handler['instance'])) {
                        $handlerObject = $handler['instance'];
                    } else {
                        // observer is an array, try to load class
                        if (!class_exists($handler['class_name'], false)) {
                            $pathSpec = rtrim($handler['include_path'], '/\\') 
                                      . DIRECTORY_SEPARATOR 
                                      . $handler['file_name'];
                            include_once $pathSpec;
                        }
                        
                        // instantiate handler
                        $handlerObject = $this->_getHandlerInstance(
                            $handler['class_name'],     // class name
                            $handler['include_path'],   // plug-in root
                            $handler['config']);        // private config

                        //TODO check usage of this duplicated config property
                        //if (isset($handler['config'])) {
                            //$handlerObject->config = $handler['config'];
                        //}
                    }
                } else if (is_object($handler)) {
                    $handlerObject = $handler;
                    $handler = array();
                }
                
                if (is_object($handlerObject)) {
                    // use event name as handler method if not specified otherwise
                    if (array_key_exists('method_name', $handler)) {
                        $handlerMethod = $handler['method_name'];
                    } else {
                        $handlerMethod = $eventName;
                    }
                    // let's see if it handles the event
                    if (method_exists($handlerObject, $eventName)) {
                        // invoke event method
                        $reflectionMethod = new ReflectionMethod(get_class($handlerObject), $handlerMethod);
                        
                        // get result of current handler
                        $tempResult = $reflectionMethod->invoke($handlerObject, $event);
                        
                        if (null !== $tempResult) {
                            $event->setValue($tempResult);
                            
                            if (is_array($tempResult)) {
                                if ($result === self::INIT_VALUE) {
                                    $result = $tempResult;
                                } else if (is_array($result)) {
                                    // If multiple plugins return an array, we merge them.
                                    $result = array_merge($result, $tempResult);
                                } else {
                                    // If another plugin returned something else, we convert to an array...
                                    $result = array_merge(array($result), $tempResult);
                                }
                            } else {
                                // TODO: Support for chaining multiple plugin results that are no arrays?
                                $result = $tempResult;
                            }
                        }
                    }
                } else {
                    // TODO: throw exception or log error?
                }
            
                $handler['instance'] = $handlerObject;
            }
        }
        
        // check whether event has been handled 
        // and set handled flag and default value
        if ($result !== self::INIT_VALUE) {
            $event->setHandled(true);
        } else {
            $result = $event->getDefault();
            $event->setHandled(false);
        }
        
        return $result;
    }
    
    /**
     * Constructor
     */
    private function __construct()
    {
        $this->_logger = Erfurt_App::getInstance()->getLog();
    }
    
    private function _registerHandler($eventName, $handler, $priority)
    {
        while (isset($this->_registeredEvents[$eventName][$priority])) {
            $priority++;
        }
        
        $this->_registeredEvents[$eventName][$priority] = $handler;
    }
    
    /**
     * Returns a previously created instance of a handler class or 
     * instantiates one if necessary.
     *
     * @param string $className
     */
    private function _getHandlerInstance($className, $root, $config)
    {
        if (!array_key_exists($className, $this->_handlerInstances)) {
            $this->_handlerInstances[$className] = new $className($root, $config);
        }
        
        return $this->_handlerInstances[$className];
    }
    
    /**
     * Returns the instance of a given plugin, iff such a plugin is registered and was
     * already handled. In the case no such plugin exists or was instanciated, this
     * method returns false.
     * 
     * @param string $pluginName
     * @return Erfurt_Plugin
     */
    public function getPluginInstance($pluginName)
    {
        $className = ucfirst($pluginName) . Erfurt_Plugin_Manager::PLUGIN_CLASS_POSTFIX;
        
        if (array_key_exists($className, $this->_handlerInstances)) {
            return $this->_handlerInstances[$className];
        } else {
            return false;
        }
    }
}

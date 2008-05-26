<?php

/**
 * Erfurt event dispatcher.
 *
 * @package    event
 * @author     Michael Haschke
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $$
 */
class Erfurt_Event_Dispatcher
{
    /** @var Erfurt_Event_Dispatcher */
    private static $_instance = null;
    
    /** @var array */
    private $_handlerInstances = array();
    
    /** @var array */
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
     *
     * @param string $eventName
     * @param object|array $handler
     */
    public function register($eventName, $handler)
    {
        // create event if not already handled
        if (!array_key_exists($eventName, $this->_registeredEvents)) {
            $this->_registeredEvents[$eventName] = array();
        }
        
        
        if (is_object($handler)) {
            // simply store handling object
            $this->_registeredEvents[$eventName][] = $handler;
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
            $this->_registeredEvents[$eventName][] = $handler;
        }
        // var_dump($this->_registeredEvents);
    }
    
    /**
     * Triggers the specified event, thereby invoking all registered observers.
     *
     * @param string $eventName
     */
    public function trigger($eventName)
    {
        $arguments = func_get_args();
        array_shift($arguments);
        
        
        // init with original value or null
        // if (isset($arguments[0])) {
        //     $result = $arguments[0];
        // } else {
            $result = null;
        // }
        
        if (array_key_exists($eventName, $this->_registeredEvents)) {
            foreach ($this->_registeredEvents[$eventName] as $handler) {
                if (is_array($handler)) {
                    // observer is an array, try to load class
                    if (!class_exists($handler['class_name'], false)) {
                        $pathSpec = rtrim($handler['include_path'], '/\\') 
                                  . DIRECTORY_SEPARATOR 
                                  . $handler['class_name'] 
                                  . '.php';
                        include_once $pathSpec;
                    }
                    
                    // instantiate handler
                    $handlerObject = $this->_getHandlerInstance($handler['class_name']);
                } else {
                    $handlerObject = $handler;
                }
                
                if (is_object($handlerObject)) {
                    // let's see if it handles the event
                    if (method_exists($handlerObject, $eventName)) {
                        // invoke event method
                        $refectionMethod = new ReflectionMethod(get_class($handlerObject), $eventName);
                        if ($tempResult = $refectionMethod->invokeArgs($handlerObject, $arguments)) {
                            $result = $tempResult;
                        }
                    }
                } else {
                    // TODO: throw exception?
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Constructor
     */
    private function __construct() {}
    
    /**
     * Returns a previously created instance of a handler class or 
     * instantiates one if necessary.
     *
     * @param string $className
     */
    private function _getHandlerInstance($className)
    {
        if (!array_key_exists($className, $this->_handlerInstances)) {
            $this->_handlerInstances[$className] = new $className();
        }
        
        return $this->_handlerInstances[$className];
    }
}


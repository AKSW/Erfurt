<?php

require_once 'Erfurt/Event/Dispatcher.php';

/**
 * Erfurt event class
 *
 * @package erfurt
 * @subpackage    event
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Event
{
    /**
     * @var Erfurt_Event_Dispatcher
     */
    protected $_eventDispatcher = null;
    
    /**
     * @var bool
     */
    protected $_handled = false;
    
    /**
     * @var string
     */
     protected $_name = null;

     /** 
      * @var array 
      */
     protected $_parameters = array();
     
     /**
      * The event's current value;
      * @var mixed
      */
     protected $_value = null;
    
    /**
     * Constructor
     */
    public function __construct($eventName)
    {
        $this->_name = (string) $eventName;
        $this->_eventDispatcher = Erfurt_Event_Dispatcher::getInstance();
    }
    
    /**
     * Returns a property value
     *
     * @param string $propertyName
     */
    public function __get($propertyName)
    {
        if (isset($this->$propertyName)) {
            return $this->_parameters[$propertyName];
        }
    }
    
    /**
     * Sets a property
     *
     * @param string $propertyName
     * @param mixed $propertyValue
     */
    public function __set($propertyName, $propertyValue)
    {        
        $this->_parameters[$propertyName] = $propertyValue;
        
        return $this;
    }
    
    /**
     * Returns whether a property with name $propertyName is set.
     *
     * @param string $propertyName The property's name
     *
     * @return boolean True if the property is set, false otherwise.
     */
    public function __isset($propertyName)
    {
        return array_key_exists($propertyName, $this->_parameters);
    }
    
    /**
     * Returns a default value for the event if one has been set or null.
     * A default value is used if the event is not handled by any handler.
     *
     * @return mixed A default value.
     */
    public function getDefault()
    {
        if (null !== $this->_default) {
            return $this->_default;
        }
    }
    
    /**
     * Returns the event name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Returns this event's parameters all at once.
     *
     * @return array An array of parameters.
     */
    public function getParams()
    {
        return $this->_parameters;
    }
    
    /**
     * Returns the current event value, as handled by previous
     * handlers or null.
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    /**
     * Returns whether this event has been handled or not.
     *
     * @return boolean
     */
    public function handled()
    {
        return $this->_handled;
    }
    
    /**
     * Sets the event's default value.
     * A default value is used if the event is not handled by any handler.
     *
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->_default = $default;
        
        return $this;
    }
    
    /**
     * Sets this event's handled state.
     *
     * @param boolean $handlet True if the event has been handled, false otherwise.
     */
    public function setHandled($handled)
    {
        $this->_handled = (bool) $handled;
        
        return $this;
    }
    
    public function setValue($value)
    {
        $this->_value = $value;
    }
    
    /**
     * Triggers this event.
     *
     * @return mixed Event handler return value
     */
    public function trigger()
    {
        return $this->_eventDispatcher->trigger($this);
    }
}


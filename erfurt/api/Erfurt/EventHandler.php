<?php
/**
 * Erfurt EventHandler
 *
 * Provides functionality to announce methods/functions to named events,
 * announced methods will be started when the event is triggered. Methods can
 * be ranked in position.
 *
 * @package erfurt
 * @author  Michael Haschke
 * @version $Id$
 */
class Erfurt_EventHandler {
    
    private $_events = array();
    private $_autoid = array();
    private $_classes = array();
    private $_autoincr = 100;
    private $_erfurt = null;
    private $_pluginManager = null;
    public $currentEventname = false;

    public function __construct($o) {
        $this->_erfurt = $o;
    }
    
	/**
	 * Erfurt_EventHandler::trigger()
	 *
	 * @param String    $eventname  name of triggered event
 	 * @param Pointer   $attribute  Pointer to one var
 	 *
 	 * @return Bool response
 	 *      o true: all started methods did return true
 	 *      o false: at least as one started method returned false
 	 *
 	 * @access public
 	 */
    public function trigger($eventname, $attribute) {
        
        # save current event name
        $this->currentEventname = $eventname;
        
        # prepare ordered function list for event
        $list = $this->_prepare($eventname);
        
        # use announced functions
        $response = true;
        foreach ($list as $function) {
        
            # prepare class and function
            if ($this->_pluginManager === null) $this->_pluginManager = $this->_erfurt->getPluginManager();
            $this->_pluginManager->prepare($function);
            
            $classMethod = explode('::',$function);
            $class = $classMethod[0];
            $method = $classMethod[1];
            
            # check for object, create object
            if (!isset($this->_classes[$class]))
                eval('$this->_classes[$class] = new '.$class.'($this->_erfurt);');

            # call method
            eval('$response = $this->_classes[$class]->'.$method.'($attribute);');
        }
        
        # delete current eventname
        $this->currentEventname = false;
        
        return $response;
        
    }
    
	/**
	 * Erfurt_EventHandler::announce()
	 * announce a function to a named event
	 *
	 * @param String    $eventname      name of triggered event
 	 * @param String    $functionname   name of function/method which should be started when event is triggered
 	 * @param Array     $position       info about ranking, array may contain one to three elements:
 	 *      o pos: integer
 	 *      o before: string or array of more strings with function names which should be started after announced function
 	 *      o after: string or array of more strings with function names which should be started before announced function
 	 *
 	 * @return Bool
 	 *      o true: function was added to event
 	 *      o false: function was not added to event
 	 *
 	 * @access public
 	 */
    public function announce($eventname,$functionname,$position=array()) {
    
        # todo: check function name for correct spelling
    
        if ($eventname && $functionname) {
            
            # auto id (auto increment)
            if (!isset($this->_autoid[$eventname]))
                $this->_autoid[$eventname] = 0;
            $functionpos = $this->_autoid[$eventname];
            if (isset($position['pos']) && is_numeric($position['pos']))
                $functionpos = $position['pos'];
            
            if (isset($position['after']) && (is_string($position['after']) || (is_array($position['after']) && count($position['after'])>0)) && !isset($position['before'])) {
                # announce after a function
                
                # check for min position
                if (is_string($position['after']))
                    $position['after'] = array($position['after']);
                sort($position['after']); # use integer keys
                $minpos = $this->isAnnounced($eventname,$position['after'][0]);
                for ($i=1; $i<count($position['after']); $i++)
                    $minpos = $this->_minPosition($minpos,$this->isAnnounced($eventname,$position['after'][$i]));
                    
                # minpos = false (after-methods do not exist)
                if ($minpos===false)
                    return $this->announce($eventname,$functionname); # insert on auto id
                    
                # check: if position is occupied then auto increment position
                while ($this->isAnnounced($eventname,$minpos) !== false) $minpos = $minpos + $this->_autoincr/2;
                
                # add function and it's position to event's function stack
                $this->_events[$eventname][$functionname] = $minpos;
            
            }
            elseif (isset($position['before']) && (is_string($position['before']) || (is_array($position['before']) && count($position['before'])>0)) && !isset($position['after'])) {
                # announce before a function
            
                # check for max position
                if (is_string($position['before']))
                    $position['before'] = array($position['before']);
                sort($position['before']); # use integer keys
                $maxpos = $this->isAnnounced($eventname,$position['before'][0]);
                for ($i=1; $i<count($position['before']); $i++)
                    $maxpos = $this->_maxPosition($maxpos,$this->isAnnounced($eventname,$position['before'][$i]));
                    
                # maxpos = false (after-methods do not exist)
                if ($maxpos===false)
                    return $this->announce($eventname,$functionname); # insert on auto id
                    
                # check: if position is occupied then auto increment position
                while ($this->isAnnounced($eventname,$maxpos) !== false) $maxpos = $maxpos - $this->_autoincr/2;
                
                # add function and it's position to event's function stack
                $this->_events[$eventname][$functionname] = $maxpos;
            
            }
            elseif (isset($position['after']) && (is_string($position['after']) || (is_array($position['after']) && count($position['after'])>0))
                    && isset($position['before']) && (is_string($position['before']) || (is_array($position['before']) && count($position['before'])>0))) {
                # announce after functionA and before functionB
                
                # check for min position
                if (is_string($position['after']))
                    $position['after'] = array($position['after']);
                sort($position['after']); # use integer keys
                $minpos = $this->isAnnounced($eventname,$position['after'][0]);
                for ($i=1; $i<count($position['after']); $i++)
                    $minpos = $this->_minPosition($minpos,$this->isAnnounced($eventname,$position['after'][$i]));

                # check for max position
                if (is_string($position['before']))
                    $position['before'] = array($position['before']);
                sort($position['before']); # use integer keys
                $maxpos = $this->isAnnounced($eventname,$position['before'][0]);
                for ($i=1; $i<count($position['before']); $i++)
                    $maxpos = $this->_maxPosition($maxpos,$this->isAnnounced($eventname,$position['before'][$i]));
                    
                if ($maxpos < $minpos) {
                    return false; # wanted position is not available
                }
                else {
                    # search for free position between minpos and maxpos (providing biggest difference)
                    $functionpos = $this->_searchFreePosition($eventname, $minpos, $maxpos);
                    
                    # add function on free position
                    $this->_events[$eventname][$functionname] = $functionpos;
                }
                
            }
            else {
                # announce on position defined by auto id
                
                # check: if position is occupied then auto increment position
                while ($this->isAnnounced($eventname,$functionpos) !== false) $functionpos = $functionpos + $this->_autoincr;
                
                # add function and it's position to event's function stack
                $this->_events[$eventname][$functionname] = $functionpos;
                
                # save last auto id (when no special position was defined)
                if (!isset($position['pos']) || !is_numeric($position['pos'])) $this->_autoid[$eventname] = $functionpos;
                
            }
            
            return true;

        }
        else {
            return false; # todo: zend exception
        }
    
    }
    
	/**
	 * Erfurt_EventHandler::reannounce()
	 * re-announce a function to a named event, parameters are exact the same
	 * like at announce(). Reannouncements only work with already announced functions.
	 *
 	 * @return Mixed
 	 *      o true: function was added to event
 	 *      o false: function was not added to event
 	 *      o null: function was not announced before
 	 *
 	 * @access public
 	 */
    public function reannounce($eventname,$functionname,$position=array()) {
    
        if ($this->isAnnounced($eventname,$functionname)!==false) {
            return $this->announce($eventname,$functionname,$position);
        }
        else {
            return null;
        }
    
    }
    
	/**
	 * Erfurt_EventHandler::isAnnounced()
	 *
	 * @param String    $eventname      name of triggered event
 	 * @param Mixed     $nameOrPosition function name or position id
 	 *      o function name must be a string
 	 *      o position must be numeric
 	 *
 	 * @return Mixed
 	 *      o false: function is not added to event or position is not occupied
 	 *      o string: function which is set to the position
 	 *      o numeric: position of function
 	 *
 	 * @access public
 	 */
    public function isAnnounced($eventname,$nameOrPosition) {
        $this->_check($eventname);
    
        if (is_numeric($nameOrPosition)) {
            # look for special position on event stack
            return array_search($nameOrPosition, $this->_events[$eventname]);
        }
        elseif (is_string($nameOrPosition)) {
            # look for method name in event stack
            if (isset($this->_events[$eventname][$nameOrPosition])) {
                # found: return position
                return $this->_events[$eventname][$nameOrPosition];
            }
            else {
                # not found: return false
                return false;
            }
        }
        else {
            return false; # todo: exception
        }
    
    }
    
	/**
	 * Erfurt_EventHandler::listAnnounced()
	 *
	 * @param String    $eventname      name of triggered event
 	 *
 	 * @return Array    sorted list of all functions which are added to a named event
 	 *      o key: functionname
 	 *      o value: position
 	 *
 	 * @access public
 	 */
    public function listAnnounced($eventname) {
        $this->_check($eventname);
        $list = $this->_events[$eventname];
        asort($list,SORT_NUMERIC);
        
        return $list;
    }
    
    private function _prepare($eventname) {
        $this->_check($eventname);
    
        $list = $this->_events[$eventname];
        asort($list,SORT_NUMERIC);
        
        return array_keys($list);
        
    }
    
    private function _searchFreePosition($eventname, $minpos, $maxpos) {
    
        # sort method list
        $list = $this->_events[$eventname];
        asort($list,SORT_NUMERIC);

        # get all methods between min and max position
        $keyBeg = array_search($minpos,$list);
        $keyEnd = array_search($maxpos,$list);
        
        $allKeys = array_keys($list);

        $numkeyBeg = array_search($keyBeg,$allKeys);
        $numkeyEnd = array_search($keyEnd,$allKeys);
        
        $methodList = array_slice($list, $numkeyBeg, $numkeyEnd - $numkeyBeg + 1, true);
        
        # look for biggest id gap between two methods
        $c = 0;
        $max = 0;
        $pos1 = 0;
        $pos2 = 0;
        $name1 = null;
        $name2 = null;
        $maxBegPos = 0;
        $maxEndPos = 0;
        $maxBegName = null;
        $maxEndName = null;
        foreach ($methodList as $functionname => $functionpos) {
            if ($c++ == 0) {
                # first step
                $name1 = $functionname;
                $pos1 = $functionpos;
            }
            else {
                # next step - compare difference between positions of functions
                $name2 = $functionname;
                $pos2 = $functionpos;
                if (max($max, $pos2-$pos1) > $max) {
                    # save info about bigger gap
                    $maxBegPos = $pos1;
                    $maxEndPos = $pos2;
                    $maxBegName = $name1;
                    $maxEndName = $name2;
                }
                $pos1 = $pos2;
                $name1 = $name2;
            }
        }
        
        # doing very difficulty math to get the midpoint between min and max
        
        $newpos = ($maxBegPos+$maxEndPos)/2;
        
        return $newpos;

    
    }
    
    private function _minPosition($value1, $value2) {
        
        if ($value1===false && is_numeric($value2)) {
            return $value2;
        }
        elseif ($value2===false && is_numeric($value1)) {
            return $value1;
        }
        elseif (is_numeric($value1) && is_numeric($value2)) {
            return max($value1, $value2);
        }
        else {
            return false;
        }
    }
    
    private function _maxPosition($value1, $value2) {
        
        if ($value1===false && is_numeric($value2)) {
            return $value2;
        }
        elseif ($value2===false && is_numeric($value1)) {
            return $value1;
        }
        elseif (is_numeric($value1) && is_numeric($value2)) {
            return min($value1, $value2);
        }
        else {
            return false;
        }
    }
    
    private function _check($eventname) {
        if (!isset($this->_events[$eventname])) $this->_events[$eventname] = array();
        return true;
    }
}

?>

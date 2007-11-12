<?php

/*
 * eventhandler.php
 * Encoding: utf-8
 *
 * Copyright (c) 2007, OntoWiki project team
 *
 * This file is part of OntoWiki.
 *
 * OntoWiki is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * OntoWiki is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OntoWiki; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
  * A short description of the file or class.
  *
  * @package: EventHandler
  * @author:  Michael Haschke
  * @version: $Id$
  */
class EventHandler {
    
    private $_events = array();
    private $_autoid = array();
    private $_autoincr = 100;

    function EventHandler() {
    
    }
    
    function trigger($eventname, $attributes) {
    
    }
    
    function announce($eventname,$functionname,array $position) {
    
        # todo: check function name for correct spelling
    
        if ($eventname && $functionname) {
            
            # auto id (auto increment)
            if (!isset($this->_autoid[$eventname]))
                $this->_autoid[$eventname] = 0;
            $functionpos = $this->_autoid[$eventname];
            if (isset($position['pos']) && is_int($position['pos']))
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
                    
                # check: if position is occupied then auto increment position
                while (!$this->isAnnounced($eventname,$minpos)) $minpos = $minpos + $this->_autoincr;
                
                # add function and it's position to event's function stack
                $this->events[$eventname][$functionname] = $minpos;
            
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
                    
                # check: if position is occupied then auto increment position
                while (!$this->isAnnounced($eventname,$maxpos)) $maxpos = $maxpos - $this->_autoincr;
                
                # add function and it's position to event's function stack
                $this->events[$eventname][$functionname] = $maxpos;
            
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
                    
                if ($maxpos < $minpos || $maxpos-$minpos==1) {
                    return false; # wanted position is not available
                }
                else {
                    # search for free position between minpos and maxpos (providing biggest difference)
                    $functionpos = $this->_searchFreePosition($eventname, array($minpos, $maxpos));
                    
                    # add function on free position or return false (no free position)
                    if ($functionpos === false) {
                        return false;
                    }
                    else {
                        $this->events[$eventname][$functionname] = $functionpos;
                    }
                }
                
            }
            else {
                # announce on position defined by auto id
                
                # check: if position is occupied then auto increment position
                while (!$this->isAnnounced($eventname,$functionpos)) $functionpos = $functionpos + $this->_autoincr;
                
                # add function and it's position to event's function stack
                $this->events[$eventname][$functionname] = $functionpos;
                
                # save last auto id (when no special position was defined)
                if (!isset($position['pos']) || !is_int($position['pos'])) $this->_autoid[$eventname] = $functionpos;
                
            }
            
            return true;

        }
        else {
            return false; # todo: zend exception
        }
    
    }
    
    function isAnounced($eventname,$nameOrPosition) {
    
        if (is_numeric($nameOrPosition)) {
            # look for special position on event stack
            return array_search($nameOrPosition, $this->events[$eventname]);
        }
        elseif (is_string($nameOrPosition)) {
            # look for method name in event stack
            if (isset($this->events[$eventname][$nameOrPosition])) {
                # found: return position
                return $this->events[$eventname][$nameOrPosition];
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
    
    function _prepare($eventname) {
    
        $list = $this->events[$eventname];
        asort($list,SORT_NUMERIC);
        
        return array_keys($list);
        
    }
    
    function _searchFree() {
    
    }
    
    function _minPosition($value1, $value2) {
        
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
    
    function _maxPosition($value1, $value2) {
        
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
}

?>

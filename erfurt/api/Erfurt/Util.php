<?php

/**
  * class providing some util methods
  *
  * @package util
  * @author Stefan Berger <berger@intersolut.de>
  * @author Norman Heino <norman@feedface.de>
  * @copyright AKSW Team
  * @version $Id$
  */
class Erfurt_Util {
	
   /**
	 * Merge two-three ini-files and returns array
	 *
	 * @param string ini files
	 * @return array ini-content
	 */
	public static function mergeIniFiles($iniFiles = array()) {
		$ret = array();
		foreach($iniFiles as $ini) {
			if (!file_exists($ini))
				throw new Erfurt_Exception("ini file: '".$ini."' doesn't exist", 601);
			# parse ini
			$ret = array_merge($ret, parse_ini_file($ini, true));
		}
		return $ret;
	}
	
	/**
	  * Replaces the value for $param in the current URL 
	  * (<code>$_SERVER['QUERY_STRING']</code>) by $value.
	  *
	  * @param $param mixed The param or an array of params whose value(s) should be replaced.
	  * @param mixed $value The new value of $param or false.
	  *
	  * @return string
	  */
	public static function replaceUrlParam($param_replace, $value_replace = false, $other_params = array()) {
		// split query string
		$queries = explode('&', urldecode($_SERVER['QUERY_STRING']));
		
		$url_params = array();
		
		// split queries in param and value
		$replaced = false;
		foreach ($queries as $query) {
			$qry = explode('=', $query);
			
			// replace value if given
			if (($qry[0] == $param_replace) || (is_array($param_replace) && in_array($qry[0], $param_replace))) {
				if ($value_replace) {
					$url_params[$qry[0]] = $value_replace;
				}
				$replaced = true;
			// don't take false or empty values over
			} elseif (($qry[1] != 'false') && $qry[1] != '' && $qry[1] != 'none') {
				$url_params[$qry[0]] = $qry[1];
			}
		}
		
		// add param if not found and hence not replaced
		if (!$replaced) {
			$url_params[$param_replace] = $value_replace;
		}
		
		// remove double params
		$url_params = array_filter($url_params);
		
		$url_head = ereg_replace('\?.*', '', $_SERVER['REQUEST_URI']);
		
		if ($query_str = http_build_query(array_merge($url_params, $other_params), '', '&amp;')) {
			return $url_head . '?' . $query_str;
		} else {
			return $url_head;
		}
	}
	
	/**
	  * Returns HTML code containing links that support paging.
	  *
	  * @param $start int the first item.
	  * @param $erg int The number of items on one page.
	  * @param $end int the last item.
	  *
	  * @return string
	  */
	public static function getListHeaderHtml($start, $count, $end) {
		
	}
	
	/**
	  * Checks whether the given string is a resource URI (either namespaced or complete).
	  *
	  * @param string $uriString the URI to be checked
	  * @return string 
	  */
	public static function isUri($uriString, $allowNameSpaced = true) {
		// TODO: check for URIs
		if (is_string($uriString)) {
			$isUri = Zend_Uri::check($uriString);

			if ($allowNameSpaced) {
				return ($isUri || preg_match('/^[a-zA-Z_]:[a-zA-Z0-9_-]+$/', $uriString));
			} else {
				return $isUri;
			}
		} else {
			throw new Erfurt_Exception('URI parameter needs to be string!');
		}
	}
	
	/**
	 * Calculates the Difference between two timestamps
	 *
	 * @param string/int $start_timestamp
	 * @param integer $end_timestamp
	 * @param integer $unit (default 0)
	 * @return string
	 * @access public
	 */
	public static function dateDifference($start_timestamp, $end_timestamp = false, $unit = 0) {
		
		if (Zend_Registry::isRegistered('strings')) {
		    $strings = Zend_Registry::get('strings');
		    
		    $approxStr  = $strings->nicedate->approx;
		    $daysStr    = $strings->nicedate->days;
		    $hoursStr   = $strings->nicedate->hours;
		    $minStr     = $strings->nicedate->min;
		    $secStr     = $strings->nicedate->sec;
		    $secsStr    = $strings->nicedate->secs;
		} else {
		    $approxStr  = 'approx.';
		    $daysStr    = 'Days';
		    $hoursStr   = 'Hours';
		    $minStr     = 'Minutes';
		    $secStr     = 'Second';
		    $secsStr    = 'Seconds';
		}
		
		
		$days_seconds_star 	= (23 * 56 * 60) + 4.091; // Star Day
		$days_seconds_sun 	= 24 * 60 * 60; // Sun Day
		
		if (is_int($start_timestamp)) {
			if ($end_timestamp) {
				$difference_seconds = $end_timestamp - $start_timestamp;
			} else {
				$end_timestamp = time();
				$difference_seconds = $end_timestamp - $start_timestamp;
			}
		} else if (is_string($start_timestamp)) {
			if ($end_timestamp) {
				if ($t = strtotime($start_timestamt)) {
						$difference_seconds = $end_timestamp - $t ;
				} else {
					throw new Exception('Error while converting time string.');
				}
			} else {
				$end_timestamp = time();
				if ($t = strtotime($start_timestamp)) {
						$difference_seconds = $end_timestamp - $t;
				} else {
					throw new Exception('Error while converting time string.');
				}
			}
		} else {
			throw new Excepton('Error while converting time string.');
		}

		switch ($unit) {
			case 3: // Days
				$difference_days = round(($difference_seconds / $days_seconds_sun));
				return $approxStr . ' ' . $difference_days . ' ' . $daysStr;
			case 2: // Hours
				$difference_hours = round(($difference_seconds / 3600));
				return $approxStr . ' ' . $difference_hours . ' ' . $hoursStr;
			case 1: // Minutes
				$difference_minutes = round(($difference_seconds / 60));
				return $approxStr . ' ' . $difference_minutes . ' ' . $minStr;
			default: // Seconds
				if ($difference_seconds > 1) {
					return $difference_seconds . ' ' . $secsStr;
				}
				else {
					return $difference_seconds . ' ' . $secStr;
				}
		}
	}
}

?>

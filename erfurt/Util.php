<?php

/**
  * class providing some util methods
  *
  * @author Stefan Berger <berger@intersolut.de>
  * @author Norman Heino <norman@feedface.de>
  * @copyright AKSW Team
  * @version $Id: Util.php 919 2007-04-01 22:48:13Z nheino $
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
			} else {
				$url_params[$qry[0]] = $qry[1];
			}
		}
		
		// add param if not found and hence not replaced
		if ($value_replace && !$replaced) {
			$url_params[$param_replace] = $value_replace;
		}
		
		// remove double params
		$url_params = array_unique($url_params);
		
		// if (isset($_SERVER['REDIRECT_URL'])) {
		// 	$url_head = $_SERVER['REDIRECT_URL'];
		// } else {
		// 	$url_head = $_SERVER['PHP_SELF'];
		// }
		
		$url_head = $_SERVER['REQUEST_URI'];
		
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
		$isUri = Zend_Uri::check($uriString);
		
		if ($allowNameSpaced) {
			return ($isUri || preg_match('/[a-zA-Z_]:[a-zA-Z0-9_-]+/', $uriString));
		} else {
			return $isUri;
		}
	}
	
}

?>

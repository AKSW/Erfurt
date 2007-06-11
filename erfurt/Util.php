<?php
/**
  * class providing some util methods
  *
  * @author Stefan Berger <berger@intersolut.de>
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
	
}
?>
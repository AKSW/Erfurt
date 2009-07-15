<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $$
 */

/**
 * OntoWiki utility class.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package  erfurt
 * @author    Natanael Arndt <arndtn@gmail.com>
 */
class Erfurt_Utils
{
	public static function isXmlPrefix ($string) {
		// The folowing regularexpression would match all allowed prefixes [1], but couses trouble with PCRE
		// '/[A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\x2FF\x370-\x37D\x37F-\x1FFF\x200C-\x200D\x2070-\x218F\x2C00-\x2FEF\x3001-\xD7FF\xF900-\xFDCF\xFDF0-\xFFFD\x10000-\xEFFFF]{1}[-A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\x2FF\x370-\x37D\x37F-\x1FFF\x200C-\x200D\x2070-\x218F\x2C00-\x2FEF\x3001-\xD7FF\xF900-\xFDCF\xFDF0-\xFFFD.0-9\xB7\x0300-\x036F\x203F-\x2040\x10000-\xEFFFF]*/u'
		// [1] http://www.w3.org/TR/REC-xml/#NT-Letter, http://www.w3.org/TR/REC-xml/#NT-NameChar
		// the first part of this regexp is incorrect

		$testResult = array();
		preg_match('/[A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\xFF]{1}[-A-Z_a-z\xC0-\xD6\xD8-\xF6\xF8-\xFF.0-9\xB7]*/u', $string, $testResult);
		if (array($testResult) && $string == $testResult[0]) {
			return true;
		} else {
			return false;
		}
	}
}
?>

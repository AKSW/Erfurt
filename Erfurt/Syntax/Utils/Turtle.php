<?php
/**
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: RdfSerializer.php 2512 2009-02-01 11:15:53Z pfrischmuth $
 */
class Erfurt_Syntax_Utils_Turtle
{
    public static function encodeString($s)
    {
        $s = str_replace("\\", "\\\\", $s);
        $s = str_replace("\t", "\\t", $s);
        $s = str_replace("\n", "\\n", $s);
        $s = str_replace("\r", "\\r", $s);
        $s = str_replace('"', '\"', $s);
        
        return $s;
    }
    
    public static function encodeLongString($s)
    {
        $s = str_replace("\\", "\\\\", $s);
        $s = str_replace('"', '\"', $s);
        
        return $s;
    }
    
    public static function findUriSplitIndex($uri)
    {
        $uriLength = strlen($uri);
        $idx = $uriLength - 1;
        
        $i = $idx;
        for($i=$idx; $i>=0; --$i) {
            if (!self::isNameChar(mb_substr($uri, $i, 1, 'UTF-8'))) {
                break;
            }
        }
        
        $idx = $i+1;
        
        for ($i=$idx; $i<$uriLength; ++$i) {
            if (self::isNameStartChar(mb_substr($uri, $i, 1, 'UTF-8'))) {
                break;
            }
        }
        
        $idx = $i;
        
        if ($idx > 0 && $idx < $uriLength) {
            return $idx;
        }
        
        return false;
    }
    
    public static function isNameChar($c)
    {
        return (
            self::isNameStartChar($c) ||
            is_numeric($c) ||
            $c === '-' ||
            self::ord($c) === 0x00B7 ||
            (self::ord($c) >= 0x0300 && self::ord($c) < 0x036F) ||
            (self::ord($c) >= 0x203F && self::ord($c) < 0x2040) 
        );
    }
    
    public static function isNameStartChar($c)
    {
        return ($c === '_' || self::isPrefixStartChar($c));
    }
    
    public static function isPrefixChar($c)
    {
        return self::isNameChar($c);
    }
    
    public static function isPrefixStartChar($c)
    {
        return (
            (self::ord($c) >= 0x41    && self::ord($c) <= 0x7A)   ||
            (self::ord($c) >= 0x00C0  && self::ord($c) <= 0x00D6) ||
            (self::ord($c) >= 0x00D8  && self::ord($c) <= 0x00F6) ||
            (self::ord($c) >= 0x00F8  && self::ord($c) <= 0x02FF) ||
            (self::ord($c) >= 0x0370  && self::ord($c) <= 0x037D) ||
            (self::ord($c) >= 0x037F  && self::ord($c) <= 0x1FFF) ||
            (self::ord($c) >= 0x200C  && self::ord($c) <= 0x200D) ||
            (self::ord($c) >= 0x2070  && self::ord($c) <= 0x218F) ||
            (self::ord($c) >= 0x2C00  && self::ord($c) <= 0x2FEF) ||
            (self::ord($c) >= 0x3001  && self::ord($c) <= 0xD7FF) ||
            (self::ord($c) >= 0xF900  && self::ord($c) <= 0xFDCF) ||
            (self::ord($c) >= 0xFDF0  && self::ord($c) <= 0xFFFD) ||
            (self::ord($c) >= 0x10000 && self::ord($c) <= 0xEFFFF) 
        );
    }
    
    public static function ord($c)
    {
        $strLen = strlen($c);
        
        if ($strLen === 1) {
            return ord($c);
        } else {
            $result = '';
            for ($i=0; $i<$strLen; ++$i) {
                $result .= dechex(ord($c[$i]));
            }
            return hexdec($result);
        }
    }
}

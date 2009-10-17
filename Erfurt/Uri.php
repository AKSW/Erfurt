<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id:$
 */

/**
 * Simple static class for performing regular expression-based URI checking and normalizing.
 * 
 * @copyright Copyright (c) 2009 {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @category Erfurt
 * @package uri
 * @author Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Uri
{
    /**
     * Regular expression to match the whole URI
     * @var string
     */
    protected static $_regExp = '/^([a-zA-Z][a-zA-Z0-9+.-]+):([^\x00-\x0f\x20\x7f<>{}|\[\]`"^\\\\])+$/';
    
    /**
     * Regular expression to extract the schema part
     * @var string
     */
    protected static $_schema = '^([a-zA-Z][a-zA-Z0-9+-.]+):';
    
    /**
     * Regular expression to extract the server part in a HTTP(S) URI
     * @var string
     */
    protected static $_server = '[^/]+';
    
    /**
     * Checks the general syntax of a given URI. Protocol-specific syntaxes are not checked.
     * Instead, only characters disallowed an all URIs lead to a rejection of the check.
     *
     * @param string $uri
     * @return string
     */
    public static function check($uri)
    {
        return (preg_match(self::$_regExp, (string)$uri) === 1);
    }
    
    /**
     * Normalizes the given URI according to {@link http://www.ietf.org/rfc/rfc2396.txt}.
     * In particular, protocol and -- for HTTP URIs -- the server part are
     * normalized to lower case.
     *
     * @param string $uri The URI to be normalized
     * @return string
     */
    public static function normalize($uri)
    {
        if (!self::check($uri)) {
            require_once 'Erfurt/Uri/Exception.php';
            throw new Erfurt_Uri_Exception('The supplied string is not a valid URI. ');
        }
        
        // split into schema and schema-specific part
        $parts          = explode(':', $uri, 2);
        $schema         = strtolower($parts[0]);
        $schemaSpecific = isset($parts[1]) === true ? $parts[1] : '';
        
        // schema-only normalization
        $normalized     = $schema
                        . ':'
                        . $schemaSpecific;
        
        // check for HTTP(S) URIs
        if (strpos('http', $schema) !== false) {
            // here we can do more ...
            $matches = array();
            preg_match('/^\/\/(.+@)?(.+?)(\/.*)?$/', $schemaSpecific, $matches);
                            
            $authority  = $matches[1];
            $server     = strtolower($matches[2]);
            $path       = isset($matches[3]) ? $matches[3] : '';
            
            // server-part normalization
            $normalized = $schema
                        . '://'
                        . $authority
                        . $server
                        . $path;
        }
        
        return $normalized;
    }
}

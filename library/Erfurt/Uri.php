<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Simple static class for performing regular expression-based URI checking and normalizing.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Uri
{
    /**
     * Regular expression to split the schema-specific part of HTTP URIs
     * @var string
     */
    protected static $_httpSplit = '/^\/\/(.+@)?(.+?)(\/.*)?$/';

    /**
     * Regular expression to match the whole URI
     * @var string
     */
    protected static $_regExp = '/^([a-zA-Z][a-zA-Z0-9+.-]+):([^\x00-\x0f\x20\x7f<>{}|\[\]`"^\\\\])+$/';

    /**
     * This preg pattern is used to check if a string is a valid qname.
     *
     * The regex follows following construction, which just covers a part of the allowed chars
     *
     * $nameStartCharNoColon = 'a-zA-Z_\xc0-\xd6\xd8-\xf6\xf8-\xff';
     * $nameCharNoColon = '-.0-9\xb7' . $nameStartCharNoColon;
     * $matchNCName = '[' . $nameStartCharNoColon . '][' . $nameCharNoColon . ']*';
     * $regExpQname = '/^(' . $matchNCName . ':)?' . $matchNCName . '$/';
     *
     */
    protected static $_regExpQname =
        '/^([a-zA-Z_\xc0-\xd6\xd8-\xf6\xf8-\xff][-.0-9\xb7a-zA-Z_\xc0-\xd6\xd8-\xf6\xf8-\xff]*:)?[a-zA-Z_\xc0-\xd6\xd8-\xf6\xf8-\xff][-.0-9\xb7a-zA-Z_\xc0-\xd6\xd8-\xf6\xf8-\xff]*$/';

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

    public static function getPathTo($uriSource, $uriTarget)
    {
        $partsSource    = explode('/', self::normalize($uriSource));
        $domainSource   = join('/', array_slice($partsSource, 0, 3));
        $partsSource    = array_slice($partsSource, 3);
        $fileSource     = array_pop($partsSource);

        $partsTarget    = explode('/', self::normalize($uriTarget));
        $domainTarget   = join('/', array_slice($partsTarget, 0, 3));
        $partsTarget    = array_slice($partsTarget, 3);
        $fileTarget     = array_pop($partsTarget);

        if ($domainSource !== $domainTarget)
            return $uriTarget;

        while ($partsSource && $partsTarget && $partsSource[0] === $partsTarget[0]) {
            array_shift($partsSource);
            array_shift($partsTarget);
        }
        $path   = "./";
        if ($partsSource) {
            $path .= str_repeat('../', count($partsSource));
        }
        foreach ($partsTarget as $part) {
            $path .= $part . '/';
        }
        return $path . $fileTarget;
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
        $normalized = $schema
            . ':'
            . $schemaSpecific;

        // check for HTTP(S) URIs
        if (strpos('http', $schema) !== false) {
            // here we can do more ...
            $matches = array();
            preg_match(self::$_httpSplit, $schemaSpecific, $matches);

            $authority = $matches[1];
            $server    = strtolower($matches[2]);
            $path      = isset($matches[3]) ? $matches[3] : '';

            // server-part normalization
            $normalized = $schema
                . '://'
                . $authority
                . $server
                . $path;
        }

        return $normalized;
    }

    /**
     * Transform a given string to full URI using the models namespaces if it
     * is a qname or check the uri if it is not a qname
     *
     * @param $qname the input qname or uri candidate
     * @param $model the Erfurt model which is used to check for namespaces
     */
    public static function getFromQnameOrUri($qnameOrUri, Erfurt_Rdf_Model $model)
    {
        // test for qname
        if (preg_match(self::$_regExpQname, (string)$qnameOrUri) == 0) {
            // input is not a qname so test for Uri-ness and return uri
            if (!self::check($qnameOrUri)) {
                throw new Erfurt_Uri_Exception('The supplied string is neither a valid Qname nor Uri by syntax.');
            } else {
                // return checked Uri
                return $qnameOrUri;
            }
        } else {
            // input is qname so split it and build Uri from namespace if possible
            $parts     = explode(':', $qnameOrUri);
            if (count($parts) > 1) {
                $prefix    = $parts[0];
                $localName = $parts[1];
                $namespace = $model->getNamespaceByPrefix($prefix);
            } else {
                // it is a local name only
                $localName = $qnameOrUri;
                $namespace = $model->getBaseIri();
            }
            $uri = $namespace . $localName;
            if (!self::check($uri)) {
                throw new Erfurt_Uri_Exception('The given qname "' . $qnameOrUri . '" results in an invalid Uri "' . $uri . '".');
            } else {
                // return constructed and checked Uri
                return $uri;
            }
        };
    }
}

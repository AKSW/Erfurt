<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package Erfurt_Cache_Frontend
 */
class Erfurt_Cache_Frontend_ObjectCache extends Zend_Cache_Core
{
    /**
     * This method is the only addition made to Zend_Cache_Core. It takes a class-instance, a function name,
     * an optional arguments array and an optional prefix for the id and generated a unique id by concatenating
     * $addtionalIdPrefix + Classname of $object + $functionName + Serialization of $args and building the md5 hash.
     *
     * @param Object $object An instance of a class.
     * @param string $functionName The name of the function, which return value should be cached.
     * @param array $args An array containing the arguments for the function call.
     * @param string $addtionalIdPrefix An optional prefix for the id generation
     *
     * @return string Returns the md5 hash of the serialization of the given parameters.
     */
    public function makeId($object, $functionName, $args = array(), $addtionalIdPrefix = '')
    {
        return md5($addtionalIdPrefix . get_class($object) . $functionName . serialize($args));
    }
}

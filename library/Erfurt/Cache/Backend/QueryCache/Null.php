<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */



/**
 * @package        Erfurt_Cache_Backend_QueryCache
 * @copyright      Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license        http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Erfurt_Cache_Backend_QueryCache_Null extends Erfurt_Cache_Backend_QueryCache_Backend {

    public function __construct()
    {
        // Nothing to do here... It is not neccessary to call the super constructor here!
    }

    // saving a Query Result according to his Query and QueryHash
     public function save ($queryId, $queryString, $graphUris, $triplePatterns, $queryResult, $duration = 0, $transactions = array()) {
        return false;
    }

    // loading a Query Result according to his QueryHash
    public function load ($queryId) {
        return false;
    }

    public function incrementHitCounter($queryId) {
        return false;
    }

    public function incrementInvalidationCounter($queryId) {
        return false;
    }

    // invalidating a cached Query Result 
    public function invalidate ($graphUri, $statements = array()) {
        return false;
    }

    public function invalidateWithModelIri ( $modelIri ) {
        return false;
    }

    public function invalidateObjectKeys ( $queryIds = array ()) {
        return false;
    }

    public function invalidateAll () {

        return true;
    }

    public function uninstall () {
        return true;
    }

    // check if a QueryResult is cached yet
    public function exists ($queryId) {
        return false;
    }

    // check the existing cacheVersion
    public function checkCacheVersion () {
        return true;
    }

    // creating the inital cacheStructure
    public function createCacheStructure () {
        return true;
    }
    
    public function getObjectKeys ( $qids = array() ) {
        return array();
    }

    public function getMaterializedViews () {
        return array();
    }

}
?>

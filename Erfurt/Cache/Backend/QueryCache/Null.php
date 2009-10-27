<?php
require_once 'Erfurt/Cache/Backend/QueryCache/Backend.php';

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

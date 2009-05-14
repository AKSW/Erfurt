<?php
require_once 'Erfurt/Cache/Backend/QueryCache/Backend.php';

class Erfurt_Cache_Backend_QueryCache_NULL extends Erfurt_Cache_Backend_QueryCache_Backend {

    // saving a Query Result according to his Query and QueryHash
     public function save ($queryId, $queryString, $graphUris, $triplePatterns, $queryResult, $duration = 0) {
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
}
?>

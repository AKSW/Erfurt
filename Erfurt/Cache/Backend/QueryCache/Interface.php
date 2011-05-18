<?php
/**
 *    Interface Definition of QueryCache-Backend-Implementations 
 *
 *    @author         Michael Martin <martin@informatik.uni-leipzig.de>
 *    @license        http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *    @link           http://code.google.com/p/ontowiki/
 *    @version        0.1
 */


/**
 * Interface Definition
 * @author         Michael Martin <martin@informatik.uni-leipzig.de>
 * @package        erfurt
 * @subpackage     cache
 * @copyright      Copyright (c) 2009 {@link http://aksw.org aksw}
 * @license        http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 * @link           http://code.google.com/p/ontowiki/
 * @version        0.1
 * @todo           some more methods needed
 */

interface Erfurt_Cache_Backend_QueryCache_Interface {


    /**
     *  saving a Query as String, its result and some more needed information
     *  @access     public
     *  @param      string    $queryId      Its a hash of the QueryString
     *  @param      string    $queryString  SPARQL Query as String
     *  @param      array   $graphUris      An Array of graphUris extracted from the From and FromNamed Clause of the SPARQL Query
     *  @param      array   $triplePatterns An Array of TriplePatterns extracted from the Where Clause of the SPARQL Query
     *  @param      string  $queryResult    the QueryResult
     *  @param      float   $duration       the duration of the originally executed Query in seconds, microseconds
     *  @return     boolean $result         returns the state of the saveprocess
     */
    public function save ( $queryId, $queryString, $modelIris, $triplePatterns, $queryResult, $duration = 0 ) ;


    /**
     *  saving a Query as String, its result and some more needed information
     *  @access     public
     *  @param      string          $queryId        Its a hash of the QueryString
     *  @return     string/boolean  $result         If a result was found it returns the result or if not then returns false
     */
    public function load ( $queryId ) ;


    /**
     *  increments the count of a query result (needed for logging)
     *  @access       public
     *  @param        string    $queryId        Its a hash of the QueryString
     */
    public function incrementHitCounter($queryId) ;

    /**
     *  increments the count of a query result (needed for logging)
     *  @access       public
     *  @param        string    $queryId        Its a hash of the QueryString
     */
    public function incrementInvalidationCounter( $queryId ) ;


    /**
     *  invalidating a cached Query Result 
     *  @access     public
     *  @param      array   $statements     an Array of statements in the form $statements[$subject][$predicate] = $object
     *  @return     int     $count          count of the affected cached queries         
     */
    public function invalidate ( $modelIri, $statements = array() ) ;

    /**
     *  invalidating all cached Query Results according to a given ModelIri 
     *  @access     public
     *  @param      string  $modelIri       A ModelIri
     *  @return     int     $count          count of the affected cached queries         
     */
    public function invalidateWithModelIri ( $modelIri ) ;

    /**
     *  invalidating all cached ObjectKeys according to a query list of QueryIds
     *  @access     public
     *  @param      string  $objectKeys     An array of Objectkeys
     */
    public function invalidateObjectKeys ( $queryIds = array ()) ;


    
    /**
     *  deleting all cachedResults
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function invalidateAll () ;


    /**
     *  deleting the initially created cacheStructure
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function uninstall () ;



    /**
     *  check if a QueryResult is cached yet
     *  @access     public
     *  @param      string          $queryId        Its a hash of the QueryString
     *  @return     boolean         $state          true / false
     */
    public function exists ( $queryId ) ;


    /**
     *  check the existing cacheVersion
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function checkCacheVersion () ;


    /**
     *  creating the initially needed cacheStructure
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function createCacheStructure () ;



    /**
     *  getObjectKeys from ObjectCache
     *  @access     public
     *  @return     array         $objectKeys
     */
    public function getObjectKeys () ;

    /**
     *  getmaterializedViews
     *  @access     public
     *  @return     array           $array of tableNames
     */
    public function getMaterializedViews () ;

}

?>

<?php
/**
 *	FrontendClass of the Query Cache
 *
 *	@author			Michael Martin <martin@informatik.uni-leipzig.de>
 *  @package        erfurt
 *  @subpackage     cache
 *  @copyright      Copyright (c) 2009 {@link http://aksw.org aksw}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/ontowiki/
 *	@version		0.1
 */
class Erfurt_Cache_Frontend_QueryCache {

    /**
     * backend Object
     * @var object
    */
    var $_backend;
    
    /**
     * Transactions for Object issignment to QueryCache
     * @var transactions
    */
    protected static $_transactions = array();

    protected static $_materializedViews;

    const ERFURT_CACHE_NO_HIT = "fae0b27c451c728867a567e8c1bb4e53";



	/**
     *	setter method for the backend implementation object
     *	@access		public
     *	@param		Erfurt_Cache_Backend_QueryCache_Backend	        $backend    backend implementation
    */
    public function setBackend( $backend ) {
        $this->_backend = $backend;
    }


    /**
     *	getter method for the backend implementation object
     *	@access		public
     *	@returns	Erfurt_Cache_Backend_QueryCache_Backend	        $backend    backend implementation
     */
    public function getBackend() {
        return $this->_backend;
    }


    /**
     *	saving a QueryString, its result and the duration of the originally executed query
     *	@access     public
     *	@param      string  $queryString    SparqlQuery
     *	@param      string  $resultFormat   the desired resultFormat
     *	@param      string  $queryResult    SparqlQuery Result
     *	@param      float   $duration       duration in seconds.microseconds
     *  @return     boolean $result         state of the saving process true/false
    */
    public function save( $queryString, $resultFormat = "plain" , $queryResult, $duration = 0 ) {

    if (!($this->_backend instanceof Erfurt_Cache_Backend_QueryCache_Null)) {
        
            //create QueryId
            $queryId = $this->createQueryId( $queryString, $resultFormat );

            //serializing the QueryResult
            $queryResult = serialize( $queryResult );
            
            //retrieve TriplePattern and graphUris
            $parsedQuery = $this->parseQuery( $queryString );
            $triplePatterns = $parsedQuery['triples'];
            $graphUris = $parsedQuery['graphs'];
            //saving the Query and the Result with the configured Backend
            $result =  $this->getBackend()->save(   $queryId, 
                                                    $queryString,
                                                    $graphUris, 
                                                    $triplePatterns, 
                                                    $queryResult, 
                                                    $duration);

            //saving transactionKeys to transactions table according to a queryId

            $objectCache = Erfurt_App::getInstance()->getCache();
            if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
                $this->getBackend()->saveTransactions ( $queryId, $this->getTransactions() ) ;
            }
            return $result;
        }
        else {
            return false;
        }
    }


    /**
     *	load a QueryResult according to its Sparql Query as String
     *  if the QueryHash not exists or no result is found its return false
     *	@access     public
     *	@param      string  $queryString    SparqlQuery 
     *  @param      string  $resultFormat   ResultFormat
     *  @return     String  $result         Resultset of the Query or false if no result exists
    */
    public function load( $queryString, $resultFormat = "plain" ) {
        
        if (!($this->_backend instanceof Erfurt_Cache_Backend_QueryCache_Null)) {
            $queryId = $this->createQueryId( $queryString, $resultFormat );

            $result = $this->getBackend()->load($queryId);

            if ($result) {
                 $result = unserialize ($result);

                if ( ((boolean) Erfurt_App::getInstance()->getConfig()->cache->query->logging ) == true) {
                    $this->getBackend()->incrementHitCounter($queryId);
                }

                //saving transactionKeys to transactions table according to a queryId
                $objectCache = Erfurt_App::getInstance()->getCache();
                if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
                    $this->getBackend()->saveTransactions ( $queryId, $this->getTransactions() ) ;
                }
                return $result;
            }
            else {
               return self::ERFURT_CACHE_NO_HIT;
            }
        }
        else {
            return self::ERFURT_CACHE_NO_HIT ;
        }
    }

 
    /**
     *	invalidating a CacheResult according to given statements
     *	@access     public
     *	@param      array   $statements     statements array in the form: statements[$subject][$predicate] = $object;
     *  @return     array   $qids           list of queryIds which are nwo invalidated
    */
    public function invalidateWithStatements( $modelIri, $statements = array() ) {
        $qids = $this->getBackend()->invalidate( $modelIri, $statements );
       if ($qids) {
            if ( ((boolean) Erfurt_App::getInstance()->getConfig()->cache->query->logging ) == true)
            {
                foreach ($qids as $qid) {
                    $this->getBackend()->incrementInvalidationCounter($qid);
                }
            }
            $objectCache = Erfurt_App::getInstance()->getCache();
            if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
                $oids = $this->_invalidateCacheObjects($qids);
            }
        }
        return $qids;
    }


    /**
     *	invalidating a CacheResult according to a given statements
     *	@access     public
     *	@param      string   $subject   subject of the triple
     *	@param      string   $predicate predicate of the triple
     *	@param      string   $object    object of the triple
     *  @return     int      $count     number of queries which was affected of the invalidation process
    */
    public function invalidate( $modelIri, $subject, $predicate, $object ) {
        $statements = array();
        $statements[$subject][$predicate][] = $object ;

        $qids = $this->invalidateWithStatements($modelIri, $statements);
        return $qids;
    }


    /**
     *	invalidating CacheResults according to a given modelIRI
     *	@access     public
     *	@param      string   $modelIri  modelIri
     *  @return     string   $status    status of the process
    */
    public function invalidateWithModelIri( $modelIri ) {

        $qids = $this->getBackend()->invalidateWithModelIri( $modelIri );
        $objectCache = Erfurt_App::getInstance()->getCache();
        if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
            $this->_invalidateCacheObjects ( $qids );
        }
        return $qids;
    }

    /**
     *	starting a Caching Transaction to assign cache Objects to queryCacheResults
     *	@access     public
     *	@param      string   $modelIri  modelIri
     *  @return     string   $status    status of the process
    */
    public function startTransaction ( $transactionKey ) {

        $objectCache = Erfurt_App::getInstance()->getCache();
        if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
            self::$_transactions[$transactionKey] = $transactionKey; 
        }
    }

    /**
     *	starting a Caching Transaction to assign cache Objects to queryCacheResults
     *	@access     public
     *	@param      string   $modelIri  modelIri
     *  @return     string   $status    status of the process
    */
    public function endTransaction ( $transactionKey ) {
        if ( isset (self::$_transactions[$transactionKey]) )
            unset ( self::$_transactions[$transactionKey] ) ; 
    }


    /**
     *	starting a Caching Transaction to assign cache Objects to queryCacheResults
     *	@access     public
     *	@param      string   $modelIri  modelIri
     *  @return     string   $status    status of the process
    */
    public function getTransactions () {
        return self::$_transactions;
    }


    public function getMaterializedViewName ($subject, $predicate, $object) {

        if (self::$_materializedViews == null) {
            self::$_materializedViews = $this->getBackend()->getMaterializedViews();

        }

        if (!($subject instanceof Erfurt_Rdf_Resource)) {
            $subject = null;
        } else {
            $subject = (string) $subject;
        }

        if (!($predicate instanceof Erfurt_Rdf_Resource)) {
            $predicate = null;
        } else {
            $predicate = (string) $predicate;
        }

        if (!($object instanceof Erfurt_Rdf_Resource)) {
            $object = null;
        } else {
            $object = (string) $object;
        }

        foreach (self::$_materializedViews as $view) {
            if (    $view['subject'] == $subject &&
                    $view['predicate'] == $predicate &&
                    $view['object'] == $object )
                return $view['tblName'];
        }
        return false;
    }



    /**
     *	starting a Caching Transaction to assign cache Objects to queryCacheResults
     *	@access     public
     *  @param      array $options (mode => "CLEAR", mode => "UNINSTALL")    
     *  @TODO       BYDURATION, BYTTL
     *  @return     string   $status    status of the process
    */
    public function cleanUpCache ($options = array()) {

        $ret = false;
        if (!isset ($options['mode']))
            return $ret;


        switch (strtolower($options['mode'])) {
            case 'clear' :
                $qids = $this->getBackend()->invalidateAll( );
                $objectCache = Erfurt_App::getInstance()->getCache();
                if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
                    $this->_invalidateCacheObjects ( $qids );
                }
                $ret = true;
            break;
            case 'uninstall' :
                $ret = $this->getBackend()->uninstall( );                
            break;

        }
        return $ret;
    }

    public function getUsedTriplePattern($limit = null, $minOccurence = null) {
        $patternList = $this->getBackend()->getUsedTriplePattern($limit, $minOccurence);
        return $patternList;
    }


    public function createMaterializedViews($limit, $minOccurence) {
        $pattern = $this->getUsedTriplePattern($limit, $minOccurence);
        return $this->getBackend()->createMaterializedViews($pattern);
    }

    public function getMaterializedViews () {
        return $this->getBackend()->getMaterializedViews();
    }


    //----------------------------------------------------
    //private Methods                                   //
    //----------------------------------------------------

    /**
     *	creating a QueryHash of a SparqlQuery
     *	@access     private
     *	@param      string   $queryString   SparqlQuery
     *	@param      string   $rsultFormat   ResultFormat
     *  @return     string   $hash          md5 generated Hash
    */
    private function createQueryId( $queryString, $resultFormat ) {   
        return md5( $queryString.$resultFormat);
    }

    /**
     *	invalidate Cache Objects
     *	@access     private
     *	@param      array   $queryIds      ListOfQueryIds
    */
    private function _invalidateCacheObjects ( $queryIds, $removeByTags = false ) {
        //requesting ObjectKeys according to the List of QueryIds
        $oKeys = $this->getBackend()->getObjectKeys ($queryIds) ;

        //create ObjectCache 
        $objectCache = Erfurt_App::getInstance()->getCache();

        //delete objects in ObjectCache
        //TODO: _clean im Objectcache umschreiben.
#        if ($removeByTags == true)
#            $eCache->clean (CLEANING_MODE_MATCHING_TAG, $oKeys) ;
        if (!($objectCache->getBackend() instanceof Erfurt_Cache_Backend_Null )) {           
            foreach ($oKeys as $oKey) {
                $objectCache->remove ($oKey) ;
            }
        }
        //im Querycache die results zu den ObjectKeys invalidieren
         $this->getBackend()->invalidateObjectKeys( $oKeys );

        return $oKeys;
    }


    /**
     *	parsing the Query
     *	@access     private
     *	@param      string   $queryString   SparqlQuery
     *  @return     array    $queryParts    $queryParts['triples'] = $triples;
     *                                      $queryParts['graphs'] = $graphs;
    */
    private function parseQuery( $queryString ) {   
        #Creation of SPARQL Parser and parsing the query string
        require_once ('Erfurt/Sparql/Parser.php');
        $parser = new Erfurt_Sparql_Parser ();
        $parsedQuery = $parser->parse( $queryString );

        #extract graphUris from FromPart and from FromNamedPart
        $graphs = $parsedQuery->getFromPart();
        $fromNamedParts = $parsedQuery->getFromNamedPart();
        foreach ($fromNamedParts as $fromNamedPart) {
            array_push ( $graphs, $fromNamedPart ); 
        }
        #extract triplePattern from parsed query and put them in an array.
        $triples = array(); #triples[0,1,2...] = array('subject' => <subject>, 'predicate' => <predicate>, 'object' => <object>,)
        $graphPatterns = $parsedQuery->getResultPart();
        foreach ( $graphPatterns as $gid => $graphPattern ) {
            $triplePatterns = $graphPattern->getTriplePatterns();
            foreach ( $triplePatterns as $tid => $triplePattern ) {
                $subject   = (string) $triplePattern->getSubject();
                $predicate = (string) $triplePattern->getPredicate();
                #Erfurt_RDF_Literal needs an __toString methode :: is given now , the following was an workaround
                #if ( get_class($triplePattern->getObject())  == 'Erfurt_Rdf_Literal') {
                #    var_dump($triplePattern->getObject());                   
                #    die;
                #}
                $object    = (string) $triplePattern->getObject();

                $triple = array();
                $this->_isVariable($subject) ? null : ($triple['subject'] = $subject);
                $this->_isVariable($predicate) ? null : ($triple['predicate'] = $predicate);
                $this->_isVariable($object) ? null : ($triple['object'] = $object);
                $triples[] = $triple ;
            }
        }
        $queryParts['triples'] = $triples;
        $queryParts['graphs'] = $graphs;

        return $queryParts;
    }


    /**
     *	checks the type of a triplePatternPart (is the subject/predicate/object a variable?)
     *	@access     public
     *	@param      string   $triplePatternPart   part of a triplePattern
     *  @return     boolean  $answer              true / false
    */
    private function _isVariable( $triplePatternPart ) {
        $regExp = '/^([?$])/';
        return (bool) preg_match( $regExp , $triplePatternPart);
    }



}
?>

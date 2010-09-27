<?php
require_once 'Erfurt/Cache/Backend/QueryCache/Backend.php';


class Erfurt_Cache_Backend_QueryCache_Database extends Erfurt_Cache_Backend_QueryCache_Backend {

    //-------------------------------------------------------------------------------	
    //public functions
    //-------------------------------------------------------------------------------

    /**
     *  check the existing cacheVersion and can used for looking up if the cache structure is beeing created
     *  @access     public
     *  @return     boolean         $state          true / false
     */
	final public function checkCacheVersion() {
        $result = false;
        try {            
            $query = 'SELECT num FROM ef_cache_query_version';
            $result = $this->store->sqlQuery($query);        
        } catch (Erfurt_Store_Adapter_Exception $f) {
            return false;
        }

		if (!$result) {
			return false;
		} else if (is_array($result) && count($result) > 0) {
		    return true;
		} else {
		    return false;
		}
	}

    /**
     *  creating the initially needed cacheStructure. In the database case there will be 6 tables created named as followed:
     *  ef_cache_query_result, ef_cache_query_triple, ef_cache_query_model, ef_cache_query_rt, ef_cache_query_rm, 
     *  ef_cache_query_version. Furthermore there are some indexes which are created. 
     *  NOTE: if this function will be called and database exists, all cached data will be deleted first.
     *  @access     public
     *  @return     boolean         $state          true / false
     */
	final public function createCacheStructure() {
        $vocabulary = array();
        switch (strtolower($this->store->getBackendName())) {
            case 'zenddb' :
            case 'mysql' :
                $vocabulary['col_utf8_bin'] = "character set utf8     collate utf8_bin";
                $vocabulary['col_ascii_bin'] = "character set ascii     collate ascii_bin";
            break;
            case 'virtuoso':
                $vocabulary['col_utf8_bin'] = "";
                $vocabulary['col_ascii_bin'] = "";
            break;
            default:
                $vocabulary['col_utf8_bin'] = "";
                $vocabulary['col_ascii_bin'] = "";
            break;
        }

        if (!$this->store->isSqlSupported()) {
            throw new Exception('To use the Query Cache, store adapter needs to implement the SQL interface.');
        }
        
        $existingTableNames = $this->store->listTables();

        if (!in_array('ef_cache_query_result', $existingTableNames)) {
            $columnSpec = array(
                'qid'           => 'VARCHAR(255)    '.$vocabulary['col_ascii_bin'].'   PRIMARY KEY NOT NULL',
                'query'         => 'LONG VARCHAR    '.$vocabulary['col_utf8_bin'].'    NULL' ,
                'result'        => 'LONG VARBINARY NULL',
                'hit_count'     => 'INT NULL',
                'inv_count'     => 'INT NULL',
                'time_stamp'    => 'FLOAT NULL',
                'duration'      => 'FLOAT NULL'
            );
            
            $this->store->createTable('ef_cache_query_result', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_result_qid ON ef_cache_query_result(qid)');
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_result_qid_count ON ef_cache_query_result(qid,hit_count,inv_count)');
        }
        
        if (!in_array('ef_cache_query_triple', $existingTableNames)) {
            $columnSpec = array(
                'tid'           => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'subject'       => 'VARCHAR(255) '.$vocabulary['col_ascii_bin'].'  NULL',
                'predicate'     => 'VARCHAR(255) '.$vocabulary['col_ascii_bin'].'  NULL',
                'object'        => 'VARCHAR(255) '.$vocabulary['col_utf8_bin'].'   NULL',
            );
            
            $this->store->createTable('ef_cache_query_triple', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_triple_tid ON ef_cache_query_triple(tid)');
        }

        if (!in_array('ef_cache_query_model', $existingTableNames)) {
            $columnSpec = array(
                'mid'           => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'modelIri'      => 'VARCHAR(255) '.$vocabulary['col_ascii_bin'].' NULL',
            );
            
            $this->store->createTable('ef_cache_query_model', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_model_mid_modelIri ON ef_cache_query_model(mid, modelIri)');
        }

        if (!in_array('ef_cache_query_rt', $existingTableNames)) {
            $columnSpec = array(
                'qid'           => 'VARCHAR(255)  '.$vocabulary['col_ascii_bin'].' NOT NULL',
                'tid'           => 'INT NOT NULL, PRIMARY KEY ( qid, tid )'
            );
            
            $this->store->createTable('ef_cache_query_rt', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_rt_qid_tid ON ef_cache_query_rt(qid, tid)');
    
        }

        if (!in_array('ef_cache_query_rm', $existingTableNames)) {
            $columnSpec = array(
                'qid'           => 'VARCHAR(255)  '.$vocabulary['col_ascii_bin'].' NOT NULL',
                'mid'           => 'INT NOT NULL, PRIMARY KEY (qid, mid)',
            );
            
            $this->store->createTable('ef_cache_query_rm', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_rm_qid_mid ON ef_cache_query_rm(qid, mid)');
        }

        if (!in_array('ef_cache_query_objectkey', $existingTableNames)) {
            $columnSpec = array(
                'qid'           => 'VARCHAR(255)  '.$vocabulary['col_ascii_bin'].' NOT NULL',
                'objectkey'     => 'VARCHAR(255)  '.$vocabulary['col_ascii_bin'].' NOT NULL, PRIMARY KEY (qid, objectkey)',
            );
            
            $this->store->createTable('ef_cache_query_objectkey', $columnSpec);
            $this->store->sqlQuery('CREATE INDEX ef_cache_query_objectkey_qid_objectkey ON ef_cache_query_objectkey (qid, objectkey)');
        }

        if (!in_array('ef_cache_query_version', $existingTableNames)) {
            $columnSpec = array(
                'num'           => 'INT NOT NULL PRIMARY KEY',
            );

            $this->store->createTable('ef_cache_query_version', $columnSpec);
            $this->store->sqlQuery('INSERT INTO ef_cache_query_version (num) VALUES (1)');
        }

	}


    /**
     *  saving a QueryString and its Result according to its QueryHash
     *  Furthermore triplePatterns from given QueryString and ModelIris (from clause) will also be saved . If array of
     *  modelIris is empty the QueryId will be assigned to a NULL-Entry . Last But not Least the duration of the originally 
     *  processed query will be saved.
     *  @access     public
     *  @param      string    $queryId        Its a hash of the QueryString
     *  @param      string    $queryString    SPARQL Query as String
     *  @param      array     $graphUris      An Array of graphUris extracted from the From and FromNamed Clause of the SPARQL Query
     *  @param      array     $triplePatterns An Array of TriplePatterns extracted from the Where Clause of the SPARQL Query
     *  @param      string    $queryResult    the QueryResult
     *  @param      float     $duration       the duration of the originally executed Query in seconds, microseconds
     *  @return     boolean   $result         returns the state of the saveprocess
     */    
    public function save( $queryId, $queryString, $modelIris, $triplePatterns, $queryResult, $duration = 0) {
        #check that this query isn't saved yet

        if ( false === $this->exists ( $queryId ) ) {
            #encoding the queryResult
            $queryResult = $this->_encodeResult( $queryResult );
            #saving the result and its according queryId
            $query = "INSERT INTO ef_cache_query_result (
                qid, 
                query,
                result,
                hit_count,
                inv_count,
                time_stamp, 
                duration) VALUES (
                '".$queryId."',
                '".(str_replace("'", "\\'", $queryString))."', 
                '".$queryResult."',
                0,
                0, 
                ".(microtime(true)).",
                ".$duration.")" ;
            $ret = $this->_query ( $query ) ;
            //saving triplePatterns in tripleTable
            $this->_saveTriplePatterns ( $queryId, $triplePatterns ) ;

            //saving modelIris in modelTable
            $this->_saveModelIris ( $queryId, $modelIris ) ;

        }
        else {
            $queryResult = $this->_encodeResult( $queryResult );
            $this->_query ( "UPDATE ef_cache_query_result SET result = '".$queryResult."', duration = ".$duration." WHERE qid = '".$queryId."'" );
        }
    }


    /**
     *  saving a Query as String, its result and some more needed information
     *  @access     public
     *  @param      string          $queryId        Its a hash of the QueryString
     *  @return     string/boolean  $result         If a result was found it returns the result or if not then returns false
     */
    public function load ( $queryId ) {
        $query = "SELECT result FROM ef_cache_query_result WHERE qid = '" . $queryId . "'" ;
        $result = $this->_query ( $query );
        if (sizeOf($result) != 0) {
            $result = $result[0]['result'] ;
            $result = $this->_decodeResult( $result );
        }
        else {
            $result = false;
        }
        return $result ;
    }


    /**
     *  increments the count of a query result (needed for logging)
     *  @access       public
     *  @param        string    $queryId        Its a hash of the QueryString
     */
    public function incrementHitCounter( $queryId ) {

        switch ($this->store->getBackendName()) {
            case "ZendDb" :
            case "MySql" :
                $count = $this->_query( "SELECT hit_count 
                                FROM ef_cache_query_result 
                                WHERE qid='".$queryId."' ") ;
                $this->_query ( "UPDATE ef_cache_query_result SET hit_count = ".($count[0]['hit_count']+1)." WHERE qid='".$queryId."' AND result IS NOT NULL" );
            break;
            case "Virtuoso":
            default:
                $query = "  UPDATE ef_cache_query_result 
                            SET hit_count = ( 
                                SELECT hit_count 
                                FROM ef_cache_query_result 
                                WHERE qid='".$queryId."' ) + 1
                            WHERE qid='".$queryId."' AND result IS NOT NULL"  ;
                $this->_query ( $query );
            break;
        }
    }


    /**
     *  increments the count of a query result (needed for logging)
     *  @access       public
     *  @param        string    $queryId        Its a hash of the QueryString
     */
    public function incrementInvalidationCounter( $queryId ) {

        switch ($this->store->getBackendName()) {
            case "ZendDb" :
            case "MySql" :
                $count = $this->_query( "SELECT inv_count 
                                FROM ef_cache_query_result 
                                WHERE qid='".$queryId."' ") ;
                $this->_query ( "UPDATE ef_cache_query_result SET inv_count = ".($count[0]['inv_count']+1)." WHERE qid='".$queryId."' AND result IS NOT NULL" );
            break;
            case "Virtuoso":
            default:
                $query = "  UPDATE ef_cache_query_result 
                            SET inv_count = ( 
                                SELECT inv_count 
                                FROM ef_cache_query_result 
                                WHERE qid='".$queryId."' ) + 1
                            WHERE qid='".$queryId."' AND result IS NOT NULL"  ;
                $this->_query ( $query );
            break;
        }
   
    }


    /**
     *  invalidating a cached Query Result 
     *  @access     public
     *  @param      array   $statements     an Array of statements in the form $statements[$subject][$predicate] = $object
     *  @return     int     $count          count of the affected cached queries         
     */
    public function invalidate ( $modelIri, $statements = array() ) {
        
        if (sizeof($statements) == 0)
            return false;

        $qids = array();
        $clauses = array();
        foreach ( $statements as $subject => $predicates ) {
            foreach ($predicates as $predicate => $objects) {
                foreach ($objects as $object) {
                    $objectValue = $object['value'] ;
                    if ($object['type'] == 'literal')
                    {
                        $objectValue = (isset($object['lang'])) ?  $objectValue . "@" . $object['lang'] : $objectValue ;
                        $objectValue = (isset($object['datatype'])) ?  $objectValue . "^^" . $object['datatype'] : $objectValue ;
                    }
                    $clause = array();
                    if ($subject != "") {
                        $clause[] = "(subject = '".addslashes($subject)."' OR subject IS NULL)" ;
                    }
                    if ($predicate != "") {
                        $clause[] = "(predicate = '".addslashes($predicate)."' OR predicate IS NULL)" ;
                    }

                    if ($objectValue != null ) {
                        $clause[] = "(object = '".addslashes($objectValue)."' OR object IS NULL)" ;
                    }
                    $clauses[] = "(". (implode (" AND ", $clause)) .")";
                

/*                   "(
                    (subject = '".$subject."' OR subject IS NULL) AND 
                    (predicate = '".$predicate."' OR predicate IS NULL) AND 
                    (object = '".$objectValue."' OR object IS NULL))"; */
                }
            }
        }

        if (count($clauses) > 20) {
            return $this->invalidateWithModelIri( $modelIri ) ;
        }

        $clauseString = implode (" OR ", $clauses);
        // retrieve List Of qids which have to vbe invalidated
        $query = "  SELECT DISTINCT (qid) 
                    FROM 
                        (
                            SELECT qid qid1
                            FROM ef_cache_query_rt JOIN ef_cache_query_triple ON ef_cache_query_rt.tid = ef_cache_query_triple.tid
                            WHERE ( ".$clauseString." )
                        ) first 
                    JOIN 
                        (
                            SELECT qid qid2
                            FROM ef_cache_query_rm JOIN ef_cache_query_model ON ef_cache_query_rm.mid = ef_cache_query_model.mid
                            WHERE ( ef_cache_query_model.modelIri = '".$modelIri."' OR ef_cache_query_model.modelIri IS NULL )
                        ) second 
                        ON first.qid1 = second.qid2 
                    JOIN 
                        ef_cache_query_result result ON result.qid = qid2 
                    WHERE result.result IS NOT NULL";
        $result = $this->_query ( $query );
        if (!$result)
            return $qids;        

        foreach ($result as $entry) {
            $qids[] = $entry['qid'];
        }
        $query = "  UPDATE ef_cache_query_result SET result = NULL 
                    WHERE 
                    (
                        qid IN 
                        (   
                            SELECT DISTINCT (qid) 
                            FROM ef_cache_query_rt JOIN ef_cache_query_triple ON ef_cache_query_rt.tid = ef_cache_query_triple.tid
                            WHERE ( ".$clauseString." )
                        ) 
                        AND qid IN
                        (
                            SELECT DISTINCT (qid) 
                            FROM ef_cache_query_rm JOIN ef_cache_query_model ON ef_cache_query_rm.mid = ef_cache_query_model.mid
                            WHERE ( ef_cache_query_model.modelIri = '".$modelIri."' OR ef_cache_query_model.modelIri IS NULL )

                        )
                    )";
        $this->_query ( $query );
        return $qids;
    }


    /**
     *  invalidating all cached Query Results according to a given ModelIri 
     *  @access     public
     *  @param      string  $modelIri       A ModelIri
     *  @return     int     $count          count of the affected cached queries         
     */
    public function invalidateWithModelIri( $modelIri ) {
        $query = "SELECT DISTINCT (qid) 
                  FROM ef_cache_query_rm JOIN ef_cache_query_model ON ef_cache_query_rm.mid = ef_cache_query_model.mid
                  WHERE ( ef_cache_query_model.modelIri = '".$modelIri."' OR ef_cache_query_model.modelIri IS NULL )";

        $qids = $this->_query ( $query );
        
        foreach ($qids as $qid) {
            $qid = $qid['qid'];

            //delete entries in query_triple
            $query = " SELECT ef_cache_query_rt.tid tid
                       FROM ef_cache_query_rt JOIN ef_cache_query_triple ON ef_cache_query_rt.tid = ef_cache_query_triple.tid
                       WHERE ( qid = '".$qid."' )" ;
            $tids = $this->_query ( $query );
            foreach ($tids as $tid) {
                $tid = $tid['tid'] ;
                $this->_query ( "DELETE FROM ef_cache_query_triple WHERE tid = '".$tid."'" );
            }

            //delete entries in query_rt 
            $this->_query ( "DELETE FROM ef_cache_query_rt WHERE qid = '".$qid."'" );

            //delete entries in query_result
            $this->_query ( "DELETE FROM ef_cache_query_result WHERE qid = '".$qid."'" );

            //delete entries in query_rm 
            $this->_query ( "DELETE FROM ef_cache_query_rm WHERE qid = '".$qid."'" );

            //delete entries in query_model
            $this->_query ( "DELETE FROM ef_cache_query_model WHERE modelIri = '".$modelIri."'" );
        }
        
        if (isset($tids)) {
            foreach ($tids as $entry) {
                $qids[] = $entry['tid'];
            }
        }

        return $qids;
    }

    /**
     *  invalidating all cached ObjectKeys according to a given list of object identiefiers
     *  @access     public
     *  @param      array  $oids       list of objectIds
     */
    public function invalidateObjectKeys ( $oids = array ()) {

        foreach ($oids as $oid) {
            //delete entries in query_objectKey
            $query = "DELETE FROM ef_cache_query_objectkey WHERE objectkey = '".$oid."'" ;
            $this->_query ( $query );
        }
    }

    /**
     *  retrieving all objectIds According to a List of queryIds
     *  @access     public
     *  @param      array  $qids       list of queryIds
     */
    public function getObjectKeys ( $qids = array() ) {
        $oKeys = array();
        foreach ($qids as $qid) {
            $query = "SELECT DISTINCT (objectkey) FROM ef_cache_query_objectkey WHERE qid='".$qid."'"; ;
            $result = $this->_query ( $query );
            foreach ($result as $entry) {
                $oKeys[$entry['objectkey']] = $entry['objectkey'];
            }
        }
        return $oKeys;
    }


    /**
     *  deleting all cachedResults
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function invalidateAll () {
        $result = $this->store->sqlQuery('SELECT qid FROM ef_cache_query_result');
        $qids = array();
        foreach ($result as $entry) {
            $qids[] = $entry['qid'];
        }        
        $this->store->sqlQuery('UPDATE ef_cache_query_result SET result = NULL'); 
        return $qids;
    }


    /**
     *  deleting the initially created cacheStructure
     *  @access     public
     *  @return     boolean         $state          true / false
     */
    public function uninstall () {

        // dropping indices isn't standard sql
        // in virtuoso it only works without ... 'ON tbl_name' else there is error 37000
        // in ZendDB (Mysql) it only works with it. e.g. 'DROP INDEX tbl_name_idx ON tbl_name'
        // TODO platform indepent index handling

	$this->store->sqlQuery('DROP TABLE ef_cache_query_triple');
	$this->store->sqlQuery('DROP TABLE ef_cache_query_model');
        $this->store->sqlQuery('DROP TABLE ef_cache_query_result');
        $this->store->sqlQuery('DROP TABLE ef_cache_query_rt');
        $this->store->sqlQuery('DROP TABLE ef_cache_query_rm');
        $this->store->sqlQuery('DROP TABLE ef_cache_query_version');
        $this->store->sqlQuery('DROP TABLE ef_cache_query_objectkey');

        return true;

    }

    /**
     *  save transactions to assign a queryid to object identifiers
     *  @access     public
     *  @param      string          $queryId        Its a hash of the QueryString
     *  @param      array           $transactions   list of object identifier
     */
    public function saveTransactions ( $queryId, $transactions ) {

        $keys = array_keys ($transactions) ;
        foreach ($keys as $key) {
            $query = "SELECT * FROM ef_cache_query_objectkey WHERE qid = '".$queryId."' AND objectkey = '".$key."'";
            $ret = $this->_query ($query);
        
            if (!(isset($ret[0]['qid']))) {
                $query = "INSERT INTO ef_cache_query_objectkey (qid, objectkey) VALUES ('".$queryId."', '".$key."')" ;
                $this->_query ($query);
            }
        }

    }


    /**
     *  check if a QueryResult is cached yet
     *  @access     public
     *  @param      string          $queryId        Its a hash of the QueryString
     *  @return     boolean         $state          true / false
     */
    public function exists ( $queryId ) {
        $query = 'SELECT * FROM ef_cache_query_result WHERE qid = \''.$queryId.'\'';
        $count = $this->_query ($query);
        if ( count($count) == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function getUsedTriplePattern($limit = NULL, $minOccurence = NULL) {

        if (null === $limit) {
            $limit = PHP_INT_MAX;
        }

        $filter = "";
        if ($minOccurence) {
            $filter = "WHERE s1.tripleHitCount > $minOccurence ";
        }

        $query = "
            SELECT  s1.tid, s2.subject, s2.predicate, s2.object, s1.tripleHitCount as tripleCount
            FROM 
            (
              SELECT rt.tid, SUM(r.hit_count +1) as tripleHitCount
              FROM 
                 ef_cache_query_rt as rt JOIN
                 ef_cache_query_result as r  ON (r.qid=rt.qid)
              GROUP BY (rt.tid)
            ) as s1 JOIN

            (
              SELECT t.tid, t.subject, t.predicate, t.object
              FROM 
                ef_cache_query_triple as t
            ) as s2 ON (s1.tid = s2.tid)
            ".$filter."
            ORDER BY tripleCount DESC 
            ".$limiter."
        ";
        $result = $this->_query ($query, (int)$limit);
        return $result;
    }

    public function createMaterializedViews ($patternList) {

	 $backendName = strtolower($this->store->getBackendName());
	 if (!($backendName == "mysql" || $backendName == "zenddb" )) {
	  return false;
	 }
	 $createdViews = array();
	 foreach ($patternList as $pattern ) {

	    $subject = $pattern['subject'];
	    $predicate = $pattern['predicate'];
	    $object = $pattern['object'];
	    if ($subject || $predicate || $object) {
	       $tableName = "ef_stmt_view_".$pattern['tid'];
	       $resCreate = $this->createNewView($tableName);
	       $resCopy = $this->copyStatementsToView($tableName, $subject, $predicate, $object);

	       $createdViews[] =array( 
		  'viewName' => $tableName,
		  'subject' => $subject,
		  'predicate' => $predicate,
		  'object' => $object,
		  'countEntries' => $resCopy);
	    }
	 }
	 return $createdViews;
    }


    private function createNewView ($tableName) {

       $query = "
	 CREATE TABLE IF NOT EXISTS `".$tableName."` (
	   `id` int(10) unsigned NOT NULL,
	   `g` int(10) unsigned NOT NULL,
	   `s` varchar(160) character set ascii collate ascii_bin NOT NULL,
	   `p` varchar(160) character set ascii collate ascii_bin NOT NULL,
	   `o` varchar(160) character set utf8 collate utf8_bin NOT NULL,
	   `s_r` int(10) unsigned default NULL,
	   `p_r` int(10) unsigned default NULL,
	   `o_r` int(10) unsigned default NULL,
	   `st` tinyint(1) unsigned NOT NULL,
	   `ot` tinyint(1) unsigned NOT NULL,
	   `ol` varchar(10) character set ascii collate ascii_bin NOT NULL,
	   `od` varchar(160) character set ascii collate ascii_bin NOT NULL,
	   `od_r` int(10) unsigned default NULL,
	   PRIMARY KEY  (`id`),
	   UNIQUE KEY `unique_stmt` (`g`,`s`,`p`,`o`,`st`,`ot`,`ol`,`od`),
	   KEY `idx_g_p_o_ot` (`g`,`p`,`o`,`ot`),
	   KEY `idx_g_o_ot` (`g`,`o`,`ot`)
	 ) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=352 ;";
       $result = $this->_query ($query);
       
       return $result;
    }

    private function copyStatementsToView($viewName, $subject, $predicate, $object) {

       $clauses = array();
       if ($subject) {
	  $clauses['s.s'] = "s.s = '".$subject."'";
       }

       if ($predicate) {
	  $clauses['s.p'] = "s.p = '".$predicate."'";
       }

       if ($object) {
	  $clauses['s.o'] = "s.o = '".$object."'";
       }

       if (sizeOf($clauses) > 0) {
	 $clauseString = "WHERE " . implode(" AND ", $clauses);
	  $query ="
	    REPLACE INTO ".$viewName." (id, g, s, p, o, s_r, p_r, o_r, st, ot, ol, od, od_r)
		SELECT s.id, s.g, s.s, s.p, s.o, s.s_r, s.p_r, s.o_r, s.st, s.ot, s.ol, s.od, s.od_r
		FROM ef_stmt as s ".$clauseString;
	  $result = $this->_query ($query);

	  $query = "SELECT COUNT(*) as count FROM ".$viewName;
	  $result = $this->_query ($query);
	  return $result[0]['count'];
       }
       return false;
    }


    public function getMaterializedViews() {

        $views = $viewTabels = $tripleIds = $whereClauses = array();
        $viewTables = $this->_query('SHOW TABLES LIKE \'ef_stmt_view%\'');
        if(!$viewTables) {
            return array();
        }

        foreach ($viewTables as $key => $viewTable) {
            $viewTable = array_values($viewTable);
            $viewName = $viewTable[0];
            $idStartPos = strrpos($viewName, "_") + 1;
            $tripleId = substr($viewName, $idStartPos );
            $views[$tripleId] = array(
                'tid' => $tripleId, 
                'tblName' => $viewName, 
            ); 
            $whereClauses[] = "tid = " . $tripleId; 
        }
        $whereClause = " WHERE " . implode (" OR ", $whereClauses);

        $query = "SELECT tid, subject, predicate, object FROM ef_cache_query_triple " . $whereClause;
        $result = $this->_query($query);
        foreach ($result as $entry) {
            $tripleId   = $entry['tid'];
            $subject    = $entry['subject'];
            $prediacte  = $entry['predicate'];
            $object     = $entry['object'];
            
            if (isset($views[$tripleId])) {
                $views[$tripleId]['subject']   = $subject ;  
                $views[$tripleId]['predicate'] = $prediacte ;
                $views[$tripleId]['object']    = $object ;

            }

        }
        return $views;
    }

    //-------------------------------------------------------------------------------
    //private functions
    //-------------------------------------------------------------------------------


    /**
     *  this private methode encapsulates the functionality for storing the triplePatterns in the triplePattern table
     *  and assigning them to the according queryResult table via a m:n table
     *  @access     private
     *  @param      string          $queryId        the Hash of the Query
     *  @param      array           $triplePatterns the Array of TriplePatterns
     */	
    private function _saveTriplePatterns ( $queryId, $triplePatterns ) {

        $defaultTP = array (
            'subject'   => 'NULL',
            'predicate'   => 'NULL',
            'object'   => 'NULL',
        );

        foreach ( $triplePatterns as $triplePattern ) {
            #initialize query, encapsulate Values with singlequotes and merge tripleValues with defaultValues
            $query = "";
            foreach ( $triplePattern as $key => $value ) {
                $triplePattern[$key] = "'".$value."'";
            }
            $triplePattern = array_merge( $defaultTP, $triplePattern );

            $tripleId = null;

            $query = "SELECT tid FROM ef_cache_query_triple WHERE 
                        subject ".(( $triplePattern['subject'] == 'NULL' ) ? "IS " : "= " ) . $triplePattern['subject'] . " AND 
                        predicate ".(( $triplePattern['predicate'] == 'NULL' ) ? "IS " : "= " ) . $triplePattern['predicate'] . " AND 
                        object ".(( $triplePattern['object'] == 'NULL' ) ? "IS " : "= " ) . $triplePattern['object'] . " ";
            $result = $this->_query ( $query );

            if ( count($result) == 0 ) {
                $query = "INSERT INTO ef_cache_query_triple (
                    subject,
                    predicate,
                    object) VALUES (
                    ".$triplePattern['subject'].",
                    ".$triplePattern['predicate'].",
                    ".$triplePattern['object'].")";
                $ret = $this->_query ( $query );
                $tripleId = $this->_getLastInsertId();
            } else {
                $tripleId = $result[0]['tid'] ;
            }
            
            // build association of triple and result

            $res = $this->_query ( "SELECT * FROM ef_cache_query_rt WHERE qid = '".$queryId."' AND tid = '".$tripleId."'" );
            if (sizeof($res) == 0) {
                $this->_query ( "INSERT INTO ef_cache_query_rt (qid, tid) VALUES ('".$queryId."','".$tripleId."')" );
            }
        }       
    }


    /**
     *  this private methode encapsulates the functionality for storing the modelIris in the model table
     *  and assigning them to the according queryResult table via a m:n table
     *  @access     private
     *  @param      string          $queryId        the Hash of the Query
     *  @param      array           $modelIris      the Array of modelIris
     */	
    private function _saveModelIris ( $queryId, $modelIris )
    {
        if ( count( $modelIris ) == 0) {
            $modelIris[] = 'NULL' ;
        } else {
            $modelIris = array_unique($modelIris);
        }

        foreach ($modelIris as $modelIri) {
            $modelId = "";

            if ($modelIri != 'NULL')
                $modelIri = "'" . $modelIri . "'";

            $query = "SELECT mid FROM ef_cache_query_model WHERE modelIri " .(($modelIri == 'NULL') ? "IS " : "= " ). $modelIri;
            $result = $this->_query ( $query );

            if ( count($result) == 0 ) {
                $query = "INSERT INTO ef_cache_query_model (modelIri) VALUES (".$modelIri.")";
                $ret = $this->_query ($query);
                $modelId = $this->_getLastInsertId();
            } else {
                $modelId = $result[0]['mid'] ;
            }


            $this->_query ( "INSERT INTO ef_cache_query_rm (qid, mid) VALUES ('".$queryId."', '".$modelId."')" );
        }
    }


    /**
     *  this private methode encapsulates the functionality to retrieve the last InsertId
     *  @access     private
     *  @return     var           $insertId      InsertId or false if an error occured
     */	
    private function _getLastInsertId() {
        try {
            return $this->store->lastInsertId() ;
        } catch (Erfurt_Store_Adapter_Exception $e) {
            $logger = Erfurt_App::getInstance()->getLog('cache');
            $logger->log($e->getMessage(), $e->getCode());
            return false;
        }        
    }


    /**
     *  this private methode encapsulates the functionality for queriing the database with SQL
     *  @access     private
     *  @param      string          $queryId        the Hash of the Query
     *  @return     resultSet       $result         the result of the SQL Query
     */	
	private function _query($sql, $limit = PHP_INT_MAX, $offset = 0) 
	{    
        $result = false;
        try {
            $result = $this->store->sqlQuery($sql, $limit, $offset); 
        } catch (Erfurt_Store_Adapter_Exception $e){
            $logger = Erfurt_App::getInstance()->getLog('cache');
            $logger->debug($e->getMessage());
            
            $result = false;    
            if (!$this->checkCacheVersion()) {
                $logger->debug('Creating query cache table structure now.');
                // In this case the tables are missing, so we try to create them once!
                // If this fails, something else is wrong, so we re-throw the error!
                try {
                    $this->createCacheStructure();
                    $result = $this->store->sqlQuery($sql, $limit, $offset);
                } catch (Erfurt_Store_Adapter_Exception $e2) {
                    $logger->debug($e2->getMessage());
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception(
                        'Something went wrong while building query cache structure: ' . $e2->getMessage()
                    );
                }
            } else {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Something went wrong with the query cache: ' . $e->getMessage().' SQL:'.$sql);
            }
        }
        
        return $result;        
	}	


    /**
     *  this private methode encapsulates the functionality for encoding the ResultSet with bas64
     *  @access     private
     *  @param      string         $result      Result as String
     *  @return     string         $result      result as base 64 erncoded String
     */	
    private function _encodeResult ( $result ) {
        $result = addslashes( $result );
        return $result;
    }	


    /**
     *  this private methode encapsulates the functionality decoding the base 64 encoded resultSet 
     *  @access     private
     *  @param      string          $result      base 64 encoded Result
     *  @return     string          $result      decoded result
     */	
    private function _decodeResult ( $result ) {
        #$result = ( $result );
        return $result;
    }	
	
}

<?php
require_once 'Zend/Cache/Backend/Interface.php';
require_once 'Zend/Cache/Backend.php';

class Erfurt_Cache_Backend_Mysqli extends Zend_Cache_Backend implements Zend_Cache_Backend_Interface {
	
	// ------------------------------------------------------------------------
	// --- Protected properties -----------------------------------------------
	// ------------------------------------------------------------------------
	
	/**
	 * available options
	 * 
	 * @var array
	 */
	protected $_options = array(
	    'host'      => false,
	    'username'  => false,
	    'password'  => false,
	    'dbname'    => false
	);
	
	// ------------------------------------------------------------------------
	// --- Private properties -------------------------------------------------
	// ------------------------------------------------------------------------
	
	/**
	 * The DB connection
	 * 
	 * @var mixed $_dbConn 
	 */
	private $_dbConn = false;
	
	// ------------------------------------------------------------------------
	// --- Magic methods ------------------------------------------------------
	// ------------------------------------------------------------------------
	
	/**
	 * Constructor
	 * 
	 * @param array $options An associative array of options
	 */
	public function __construct($options = array()) {
		
		parent::__construct($options);
		if ($this->_options['host'] === false) {
		    require_once 'Erfurt/Exception.php';
		    throw new Erfurt_Exception('host not given');
		}
		if ($this->_options['username'] === false) {
		    require_once 'Erfurt/Exception.php';
		    throw new Erfurt_Exception('username not given');
		}
		if ($this->_options['password'] === false) {
		    require_once 'Erfurt/Exception.php';
		    throw new Erfurt_Exception('password not given');
		}
		if ($this->_options['dbname'] === false) {
		    require_once 'Erfurt/Exception.php';
		    throw new Erfurt_Exception('dbname not given');
		}
		
		$this->_getConnection();
	}
	
	public function __destruct() {
		
		$this->_closeConnection();
	}
	
	// ------------------------------------------------------------------------
	// --- Public methods -----------------------------------------------------
	// ------------------------------------------------------------------------
	
	/**
     * Clean some cache records.
     *
     * Available modes are :
     * Zend_Cache::CLEANING_MODE_ALL (default)    => remove all cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_OLD              => remove too old cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_MATCHING_TAG     => remove cache entries matching all given tags
     *                                               ($tags can be an array of strings or a single string)
     * Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG => remove cache entries not {matching one of the given tags}
     *                                               ($tags can be an array of strings or a single string)
     *
     * @param string $mode clean mode
     * @param array $tags array of tags
     * @return boolean true if no problem
     */
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {
        
		$return = $this->_clean($mode, $tags);
        
        return $return;
    }
	
	/**
     * Test if a cache is available for the given id and return it.
     *
     * @param string $id cache id
     * @param boolean $doNotTestCacheValidity if set to true, the cache validity won't be tested
     * @return string cached datas (or false)
     */
    public function load($id, $doNotTestCacheValidity = false) {

        $sql = 'SELECT content FROM ef_cache WHERE id = "' . $id . '"';

        if (!$doNotTestCacheValidity) {
            $sql .= ' AND (expire = 0 OR expire > ' . time() . ')';
        }

        $result = $this->_query($sql);

		if ($result !== false) {
			$row = @$result->fetch_row();
	        if ($row) {
	            return $row[0];
	        }
		}
		
        return false;
    }

	/**
     * Remove a cache record.
     *
     * @param string $id cache id
     * @return boolean true if no problem
     */
    public function remove($id) {
	
        $res = $this->_query('SELECT COUNT(*) AS nbr FROM ef_cache WHERE id = "' . $id . '"');
		$res = @$res->fetch_row();

        $result1 = $res[0];
        $result2 = $this->_query('DELETE FROM ef_cache WHERE id = "' . $id . '"');
        $result3 = $this->_query('DELETE FROM tag WHERE id = "' . $id . '"');

        return ($result1 && $result2 && $result3);
    }

	/**
     * Save some string datas into a cache record
     *
     * Note : $data is always "string" (serialization is done by the
     * core not by the backend)
     *
     * @param string $data datas to cache
     * @param string $id cache id
     * @param array $tags array of strings, the cache record will be tagged by each string entry
     * @param int $specificLifetime if != false, set a specific lifetime for this cache record (null => infinite
     *  	  lifetime)
     * @return boolean true if no problem
     */
    public function save($data, $id, $tags = array(), $specificLifetime = false) {
	
        if (!$this->_checkStructureVersion()) {	
            $this->_buildStructure();
            if (!$this->_checkStructureVersion()) {
                Zend_Cache::throwException('Impossible to build cache structure.');
            }
        }

        $lifetime = $this->getLifetime($specificLifetime);
        $data = $this->_getConnection()->real_escape_string($data);
        $mktime = time();
        if (is_null($lifetime)) {
            $expire = 0;
        } else {
            $expire = $mktime + $lifetime;
        }

        $this->_query('DELETE FROM ef_cache WHERE id = "' . $id . '"');      
		$sql = 'INSERT INTO ef_cache (id, content, lastModified, expire) 
				VALUES ("' . $id . '", "' . $data . '", ' . $mktime . ', ' . $expire . ')';
        $res = $this->_query($sql);
        if (!$res) {
            $this->_log('Erfurt_Cache_Backend_Mysqli::save() : impossible to store the cache id=' . $id, 7);
            return false;
        }
        $res = true;

        foreach ($tags as $tag) {
            $res = $res && $this->_registerTag($id, $tag);
        }

        return $res;
    }

	/**
     * Test if a cache is available or not (for the given id)
     *
     * @param string $id cache id
     * @return mixed false (a cache is not available) or "last modified" timestamp (int) of the available cache record
     */
    public function test($id) {
	
        $sql = 'SELECT lastModified FROM ef_cache WHERE id = "' . $id . '" AND (expire = 0 OR expire > ' . time() . ')';
        $result = $this->_query($sql);
        $row = @$result->fetch_row();
        if ($row) {
            return ((int)$row[0]);
        }

        return false;
    }

	// ------------------------------------------------------------------------
	// --- Private methods ----------------------------------------------------
	// ------------------------------------------------------------------------
	
	/**
	 * This method will build the database structure.
	 */
	private function _buildStructure() {

		$this->_query('DROP INDEX ef_cache_tag_id_index');
        $this->_query('DROP INDEX ef_cache_tag_name_index');
        $this->_query('DROP INDEX ef_cache_id_expire_index');
		$this->_query('DROP TABLE ef_cache_version');
        $this->_query('DROP TABLE ef_cache');
        $this->_query('DROP TABLE ef_cache_tag');
		
		$this->_query('CREATE TABLE ef_cache_version (
							num 			INT PRIMARY KEY)');
		
        $this->_query('CREATE TABLE ef_cache (
							id 				VARCHAR(255) PRIMARY KEY, 
							content 		BLOB, 
							lastModified 	INT, 
							expire 			INT)');
					
        $this->_query('CREATE TABLE ef_cache_tag (
							name 			VARCHAR(255), 
							id 				VARCHAR(255))');

        $this->_query('CREATE INDEX ef_cache_tag_id_index ON ef_cache_tag(id)');
        $this->_query('CREATE INDEX ef_cache_tag_name_index ON ef_cache_tag(name)');
        $this->_query('CREATE INDEX ef_cache_id_expire_index ON ef_cache(id, expire)');

		$this->_query('INSERT INTO ef_cache_version (num) VALUES (1)');

	}
	
	/**
	 * This method will check whether the db structure is created.
	 */
	private function _checkStructureVersion() {

		$result = $this->_query('SELECT num FROM ef_cache_version');

		if (!$result) {
			
			return false;
		}
		
		return true;
	}
	
	/**
     * Clean some cache records.
     *
     * Available modes are :
     * Zend_Cache::CLEANING_MODE_ALL (default)    => remove all cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_OLD              => remove too old cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_MATCHING_TAG     => remove cache entries matching all given tags
     *                                               ($tags can be an array of strings or a single string)
     * Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG => remove cache entries not {matching one of the given tags}
     *                                               ($tags can be an array of strings or a single string)
     *
     * @param string $mode clean mode
     * @param array $tags array of tags
     * @return boolean true if no problem
     */
    private function _clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {
	
        if ($mode === Zend_Cache::CLEANING_MODE_ALL) {
            $res1 = $this->_query('DELETE FROM ef_cache');
            $res2 = $this->_query('DELETE FROM ef_cache_tag');

            return ($res1 && $res2);
        }

        if ($mode === Zend_Cache::CLEANING_MODE_OLD) {
            $mktime = time();
			
			$sql1 = 'DELETE FROM ef_cache_tag WHERE id IN 
						(SELECT id FROM ef_cache WHERE expire > 0 AND expire <= ' . $mktime . ')';
            $res1 = $this->_query($sql1);

			$sql2 = 'DELETE FROM ef_cache WHERE expire > 0 AND expire <= ' . $mktime;
            $res2 = $this->_query($sql2);

            return ($res1 && $res2);
        }

        if ($mode == Zend_Cache::CLEANING_MODE_MATCHING_TAG) {
            $first = true;
            $ids = array();
            foreach ($tags as $tag) {
                $res = $this->_query('SELECT DISTINCT(id) AS id FROM ef_cache_tag WHERE name = "' . $tag . '"');
                if (!$res) {
                    return false;
                }
             
                $ids2 = array();
				while (($row = @$res->fetch_row())) {
                    $ids2[] = $row[0];
                }
                if ($first) {
                    $ids = $ids2;
                    $first = false;
                } else {
                    $ids = array_intersect($ids, $ids2);
                }
            }
            $result = true;
            foreach ($ids as $id) {
                $result = $result && ($this->remove($id));
            }
            
			return $result;
        }

        if ($mode === Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG) {
            $res = $this->_query('SELECT id FROM ef_cache');
            $result = true;
            while (($row = @$res->fetch_row())) {
                $id = $row[0];
                $matching = false;
                foreach ($tags as $tag) {
					$sql = 'SELECT COUNT(*) AS nbr FROM ef_cache_tag WHERE name = "' . $tag . '" AND id = "' 
						 . $id . '"';
                    $res = $this->_query($sql);
                    if (!$res) {
                        return false;
                    }
					$res = @$res->fetch_row();
                    $nbr = (int)$res[0];
                    if ($nbr > 0) {
                        $matching = true;
                    }
                }
                if (!$matching) {
                    $result = $result && $this->remove($id);
                }
            }

            return $result;
        }

        return false;
    }
	
	/**
	 * Closes the connection to the db.
	 */
	private function _closeConnection() {
		
		if ($this->_dbConn) {
			$this->_dbConn->close();
		}
		
		$this->_dbConn = false;
	}
	
	/**
	 * @return resource Returns the resource for the db connection.
	 */
	private function _getConnection() {
		
		if (!$this->_dbConn) {
			
			$dbHost 	= $this->_options['host'];
			$dbUser 	= $this->_options['username'];
			$dbPassword	= $this->_options['password'];
			$dbName 	= $this->_options['dbname'];
			
			$this->_dbConn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
			
			if (mysqli_connect_errno()) {
				require_once 'Zend/Cache.php';
				Zend_Cache::throwException('Could not connect to cache database.');
			}
		}
		
		return $this->_dbConn;
	}
	
	private function _query($sql) {
		
		$dbConn = $this->_getConnection();
		if ($dbConn) {
			$result = $dbConn->query($sql);
			
			return $result;
		} else {
			return false;
		}
	}
	
	/**
     * Register a cache id with the given tag.
     *
     * @param string $id cache id
     * @param string $tag tag
     * @return boolean true if no problem
     */
    private function _registerTag($id, $tag) {
	
        $res = $this->_query('DELETE FROM ef_cache_tag WHERE name = "' . $tag . '" AND id = "' . $id . '"');
        $res = $this->_query('INSERT INTO ef_cache_tag (name, id) VALUES ("' . $tag . '", "' . $id . '")');
        
		if (!$res) {
            $this->_log('Erfurt_Cache_Backend_Mysqli::_registerTag() : impossible to register tag=' . $tag 
				 . ' on id=' . $id, 7);
            return false;
        }

        return true;
    }
	
	
	
	
}

?>

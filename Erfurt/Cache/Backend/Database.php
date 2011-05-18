<?php
require_once 'Zend/Cache/Backend/Interface.php';
require_once 'Zend/Cache/Backend.php';

class Erfurt_Cache_Backend_Database extends Zend_Cache_Backend implements Zend_Cache_Backend_Interface {

    public $store = null;
	
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
                
        $this->store = Erfurt_App::getInstance()->getStore();
	}
	
	public function __destruct() {
		
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

        $sql = "SELECT content FROM ef_cache WHERE id = '" . $id . "'";
        if (!$doNotTestCacheValidity) {
            $sql .= " AND (expire = 0 OR expire > " . time() . ")";
        }

        $result = $this->_query($sql);
		if ($result !== false) {
            if (isset($result[0])) {
                $content = $result[0]['content'];
                #$content = base64_decode($content);
	            return $content;
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

        $result2 = $this->_query("DELETE FROM ef_cache WHERE id = '" . $id . "'");
        $result3 = $this->_query("DELETE FROM ef_cache_tag WHERE id = '" . $id . "'");

        return ($result2 && $result3);
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
        #$data = $this->_getConnection()->real_escape_string($data);
        $data = addslashes($data);
        $mktime = time();
        if (is_null($lifetime)) {
            $expire = 0;
        } else {
            $expire = $mktime + $lifetime;
        }

        $this->_query("DELETE FROM ef_cache WHERE id = '" . $id . "'");      
		$sql = "INSERT INTO ef_cache (id, content, lastModified, expire) 
				VALUES ('" . $id . "', '" . $data . "', ' . $mktime . ', ' . $expire . ')";
        $this->_query($sql);
        $res = $this->store->lastInsertId();

        if ($res != "0" && !$res) {
            $this->_log('Erfurt_Cache_Backend_Database::save() : impossible to store the cache id=' . $id, 7);
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
	
        $sql = "SELECT lastModified FROM ef_cache WHERE id = '" . $id . "' AND (expire = 0 OR expire > " . time() . ")";
        $result = $this->_query($sql);

        if ($result[0]) {
            return ((int) $result[0]['lastModified']);
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
#		$this->_query('DROP INDEX ef_cache_tag_id_index');
#        $this->_query('DROP INDEX ef_cache_tag_name_index');
#        $this->_query('DROP INDEX ef_cache_id_expire_index');
#		$this->_query('DROP TABLE ef_cache_version');
#        $this->_query('DROP TABLE ef_cache');
#        $this->_query('DROP TABLE ef_cache_tag');
		
		$this->_query(' CREATE TABLE ef_cache_version (
							num     INT,
                        PRIMARY KEY (num))');
		
        $this->_query(' CREATE TABLE ef_cache (
							id 				VARCHAR(255) , 
							content 		LONG VARBINARY , 
							lastModified 	INT , 
							expire 			INT,
                        PRIMARY KEY (id))');
					
        $this->_query(' CREATE TABLE ef_cache_tag (
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
			
			$sql1 = "DELETE FROM ef_cache_tag WHERE id IN 
						(SELECT id FROM ef_cache WHERE expire > 0 AND expire <= " . $mktime . ")";
            $res1 = $this->_query($sql1);

			$sql2 = "DELETE FROM ef_cache WHERE expire > 0 AND expire <= " . $mktime;
            $res2 = $this->_query($sql2);

            return ($res1 && $res2);
        }

        if ($mode == Zend_Cache::CLEANING_MODE_MATCHING_TAG) {

            if (sizeOf($tags) < 1) {
                return false;
            }

            $conditions = array();
            $sql = "SELECT DISTINCT(id) AS id FROM ef_cache_tag as tag WHERE ";
            
            foreach ($tags as $tag) {
                $conditions[] = "EXISTS (SELECT id FROM ef_cache_tag WHERE name = '" . $tag . "' AND id=tag.id) ";
            }
            $sql .= implode(" AND ", $conditions);
            $result = $this->_query($sql);
            $res = true;
            foreach ($result as $entry) {
                    $res = $res && $this->remove($entry['id']);
            }
  		    return $res;
        }

        if ($mode === Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG) {
            $res = $this->_query('SELECT id FROM ef_cache');
            $result = true;
            while (($row = @$res->fetch_row())) {
                $id = $row[0];
                $matching = false;
                foreach ($tags as $tag) {
					$sql = "SELECT COUNT(*) AS nbr FROM ef_cache_tag WHERE name = '" . $tag . "' AND id = '" . $id . "'";
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
	

	private function _query($sql) {
		
        try {
            $result = $this->store->sqlQuery( $sql );        
        } catch (Erfurt_Store_Adapter_Exception $e){
            $logger = Erfurt_App::getInstance()->getLog('cache');
            $logger->log($e->getMessage(), $e->getCode());
            return false;
        }
        return $result;
	}
	
	/**
     * Register a cache id with the given tag.
     *
     * @param string $id cache id
     * @param string $tag tag
     * @return boolean true if no problem
     */
    private function _registerTag($id, $tag) {
	
        $res = $this->_query("DELETE FROM ef_cache_tag WHERE name = '" . $tag . "' AND id = '" . $id . "'");
        $res = $this->_query("INSERT INTO ef_cache_tag (name, id) VALUES ('" . $tag . "', '" . $id . "')");
        
		if (!$res) {
            $this->_log('Erfurt_Cache_Backend_Mysqli::_registerTag() : impossible to register tag=' . $tag 
				 . ' on id=' . $id, 7);
            return false;
        }

        return true;
    }
	
	
	
	
}

?>

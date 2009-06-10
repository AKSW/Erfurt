<?php
/**
 *	AbstractClass of QueryCache-Backend-Implementations 
 *
 *	@author			Michael Martin <martin@informatik.uni-leipzig.de>
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/ontowiki/
 *	@version		0.1
 */
require_once 'Erfurt/Cache/Backend/QueryCache/Interface.php';

/**
 *	AbstractClass Erfurt_Cache_Backend_QueryCache_Backend which implements Erfurt_Cache_Backend_QueryCache_Interface
 *	@author			Michael Martin <martin@informatik.uni-leipzig.de>
 *  @package        erfurt
 *  @subpackage     cache
 *  @copyright      Copyright (c) 2009 {@link http://aksw.org aksw}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/ontowiki/
 *	@version		0.1
 */
abstract class Erfurt_Cache_Backend_QueryCache_Backend implements Erfurt_Cache_Backend_QueryCache_Interface {

    //Reference to Erfurt Store
    public $store = null;

    /**
     *	magic constructor which is checking the cache Version and calling the function for initial cache structure creation
     *	@access		public
    */
	public function __construct() { 
        $this->store = Erfurt_App::getInstance()->getStore();
    }

    /**
     *	magic destructor 
     *	@access		public
    */
	public function __destruct() {
	}

}

?>

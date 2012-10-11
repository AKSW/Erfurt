<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Cache/Backend/QueryCache/Interface.php';

/**
 * AbstractClass of QueryCache-Backend-Implementations
 * AbstractClass Erfurt_Cache_Backend_QueryCache_Backend which implements Erfurt_Cache_Backend_QueryCache_Interface
 *
 * @author Michael Martin <martin@informatik.uni-leipzig.de>
 * @package Erfurt_Cache_Backend_QueryCache
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
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

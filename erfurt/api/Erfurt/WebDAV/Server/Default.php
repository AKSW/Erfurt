<?php

/**
 * WebDAV-supporting-class for browsing ontologies inside Erfurt-API
 * 
 * @package WebDAV
 * @author Christoph Rieß <c.riess@polizisten-duzer.de>
 * @version $Id$
 */
require_once 'HTTP/WebDAV/Server.php';

class Erfurt_WebDAV_Server_Default extends HTTP_WebDAV_Server {
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $erfurt;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $arPath;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $arModelURI;
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $config
	 */
	public function __construct($config = null) {

		$this -> erfurt = new Erfurt_App_Default($config);
		
		$this -> arModelURI = array();
		
		foreach ($this -> erfurt -> getStore() -> listModels( true ) as $model ) {
			$this -> arModelURI[] = $model['modelURI'];
		}
		
		parent::__construct();
		
		$this->arPath = array();
		
		$path_info = empty($this->_SERVER["PATH_INFO"]) ? "/" : $this->_SERVER["PATH_INFO"];
		
		$arPath = explode( '/' , $path_info);
		 
		foreach ($arPath as $partPath) {
			if (strlen($partPath) > 0) {
				$this->arPath[] = $partPath;
			}
		}
	
	}
	
	/**
	 * Calls SevrveRequest() of Superclass
	 *
	 */
	public function ServeRequest() {
		
		 parent::ServeRequest();
		 
	}
	
	/**
	 * PROPFIND Implementation
	 */
	public function PROPFIND($options, &$files) {
		
		if (sizeof($this->arPath) > 0) {
			$this->handleModel($this->getModelNr($this->arPath[0]));
		} else {
			foreach ($this->arModelURI as $key => $uri) {
				$files['files'][] = $this -> addDirectory('/Model_' . $key . '/');
			}
		}
		
		return true;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @param unknown_type $name
	 */
	public function addDirectory($path,$name = null) {
		$arDirectory = array();

		$arDirectory["path"]  =$path;
		
		$arDirectory["props"] = array();
		
		if (!is_null($name)) {
			$arDirectory["props"][] = $this->mkprop('displayname',$name);
		}
		
		$arDirectory["props"][] = $this->mkprop("resourcetype", "collection");
		
		return $arDirectory;
	}
	
	/**
	 * Enter description here...
	 *
	 */
	public function addFile() {
		
	}
}
?>
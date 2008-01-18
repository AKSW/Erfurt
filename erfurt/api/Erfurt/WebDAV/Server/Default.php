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
	private $strPath;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $arModels;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $arFiles;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $selectedModel;
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $config
	 */
	public function __construct($config = null) {
		
		parent::__construct();
		
		ini_set("display_errors", true);
		
		$this -> erfurt = new Erfurt_App_Default($config);
		
		$this -> arPath = array();
		
		$this -> strPath = empty($this->_SERVER['PATH_INFO']) ? '/' : $this->_SERVER['PATH_INFO'];
		
		$arPathTemp = explode( '/' , $this -> strPath);
		
		foreach ($arPathTemp as $pathValue) {
			if (strlen($pathValue) > 0)
				$this -> arPath[] = $pathValue;
		}
		
		if (sizeof($this -> arPath) > 0) {
			$this -> selectedModel = $this -> erfurt -> getStore() ->
			getModel(str_replace('|','/',$this -> arPath[0]));
		} else {
			$this -> arModels = $this -> erfurt -> getStore() -> listModels();
		}		
	
	}
	
	/**
	 * Enter description here...
	 *
	 */
	public function ServeRequest() {
		
		 parent::ServeRequest();
		 
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $options
	 * @param unknown_type $files
	 */
	public function PUT($options, &$files = NULL) {
		
		$lastToken = $this -> arPath[sizeof($this -> arPath) - 1];
		$fileType = strrchr($lastToken,'.');

		$import = stream_get_contents($options['stream']);
		
		$temp = tmpfile();
		fwrite($temp, $import);
		$metadata = stream_get_meta_data( $temp );
		
		$tempModel = new MemModel();
		$tempModel -> load($metadata['uri'], substr( $fileType, 1) ,false);
		fclose($temp); // dies entfernt die Datei
		$this -> selectedModel -> addModel( $tempModel );
		
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $options
	 * @param unknown_type $files
	 */
	public function GET($options, &$files = NULL) {
		
		$lastToken = $this -> arPath[sizeof($this -> arPath) - 1];
		$fileType = strrchr($lastToken,'.');
		
		if ( $fileType == '.n3' || $fileType == '.rdf' ) {
			
			$resourceUri = str_replace($fileType,'',$lastToken);
			echo $this -> fileExport($resourceUri,$fileType);
			
		} else {
			
			$this -> PROPFIND($options,$files);
		
			if (is_null($files) || sizeof ($files['files']) == 0 ) {
				echo '404 Not Found';
			} else {
				foreach ($files['files'] as $arFile) {
					$strPath = $arFile['path'];
					echo '<a href="' . $this -> base_uri . $strPath . '">' . substr($strPath,strrpos($strPath,'/') + 1) . '</a> <br/>';
				}
			}
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $options
	 * @param unknown_type $files
	 * @return unknown
	 */
	public function PROPFIND($options, &$files) {
		
		$depth = sizeof($this -> arPath);
		
		if ($depth == 0) {
			foreach ($this -> arModels as $m) {
				$modelURI = str_replace('/','|',$m -> modelURI);
				$files['files'][] = $this -> addDirectory($modelURI);
			}
			return true;
			
		} else {
			
			if ($depth == 1) {
				$files['files'][] = $this -> addDirectory('classes');
				$files['files'][] = $this -> addDirectory('resources');
				return true;
				
			} else {
				
				if ($this -> arPath[1] == 'classes') {
					$files['files'] = $this -> handleClasses(array_slice( $this -> arPath , 2 ));
					return true;
				} elseif ($this -> arPath[1] == 'resources') {
					$files['files'] = $this -> handleResources(array_slice( $this -> arPath , 2 ));
					return true;
				}
				
			}
			
		}
		
		return false;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @param unknown_type $name
	 */
	private function addDirectory($path, $name = null) {
		$arDirectory = array();

		$arDirectory["path"]  = $this -> _slashify($this -> strPath) . $path ;
		
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
	private function addFile($path, $name = null, $mime = 'unknown', $size = 0) {
		$arFile = array();

		$arFile["path"]  = $this -> _slashify($this -> strPath) . $path;
		
		$arFile["props"] = array();
		
		if (!is_null($name)) {
			$arFile["props"][] = $this->mkprop('displayname',$name);
		}
		
		return $arFile;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $subPath
	 */
	private function handleClasses($subPath) {
		
		$depth = sizeof($subPath);
		$files = array();
		
		
		foreach ($this -> selectedModel -> getParsedNamespaces() as $uri => $ns) {
			$prefixes .= 'PREFIX ' . $ns . ': <' . $uri . '>' . PHP_EOL;
		}
		
		if ($depth == 0) {
			foreach ($this -> selectedModel -> listTopClasses(true,true,true) as $class) {
				$files[] = $this -> addDirectory( $class -> getQualifiedName() );
			}
		} else {
			$query = $prefixes . 'SELECT ?class ' . PHP_EOL .
			'WHERE {?class <' . EF_RDFS_SUBCLASSOF . '> ' . $subPath[$depth-1] . ' . }';
			$res = $this -> erfurt -> getStore() -> executeSparql(
			$this -> selectedModel , $query , null , null , true 
			);
			foreach ($res as $class) {
				$files[] = $this -> addDirectory( $class['?class'] -> getQualifiedName() );
			}
//			$files[] = $this -> addDirectory( 'all instances' );
			$files[] = $this -> addFile( $subPath[$depth-1] . '.n3' );
			$files[] = $this -> addFile( $subPath[$depth-1] . '.rdf' );
		}
		
		return $files;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $subPath
	 */
	private function handleResources($subPath) {
		
		$depth = sizeof($subPath);
		$files = array();
		
		
		foreach ($this -> selectedModel -> getParsedNamespaces() as $uri => $ns) {
			$prefixes .= 'PREFIX ' . $ns . ': <' . $uri . '>' . PHP_EOL;
		}
		
		if ($depth == 0) {
			
			$query = $prefixes . 'SELECT DISTINCT ?subject ' . PHP_EOL .
			'WHERE {?subject ?predicate ?object . } ORDER BY ?subject ';
			
			$result = $this -> erfurt -> getStore() -> executeSparql(
			$this -> selectedModel , $query , null , null , true 
			);
			
			for ($i = 0; $i <= sizeof($result); $i = $i + 50) {
				$files[] = $this -> addDirectory( 'R_' . $i . '_' . ($i + 49) );
			}
			
		} elseif ($depth == 1) {
			
			$offset = explode ('_',$subPath[0]);
			$query = $prefixes . 'SELECT DISTINCT ?subject ' . PHP_EOL .
			'WHERE {?subject ?predicate ?object . } ORDER BY ?subject ' . PHP_EOL .
			'OFFSET ' . $offset[1] . ' LIMIT 50';
			
			$result = $this -> erfurt -> getStore() -> executeSparql(
			$this -> selectedModel , $query , null , null , true 
			);
			
			foreach ($result as $r) {
				$files[] = $this -> addDirectory( $r['?subject'] -> getQualifiedName() );
			}
			
		} elseif ($depth == 2) {
			
			$files[] = $this -> addFile( $subPath[$depth-1] . '.n3' );
			$files[] = $this -> addFile( $subPath[$depth-1] . '.rdf' );
			
		}
		
		return $files;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $resUri
	 * @param unknown_type $fileType
	 */
	private function fileExport($resUri,$fileType) {
		
		$model = $this -> selectedModel;
		$r = $model->resourceF($resUri);
		$m = $r->getDefiningModel();
		
		if ($fileType == '.rdf') {
			
			$xmlWriter = new Erfurt_Syntax_StringWriterXMLImpl();
			$rdfSerializer = new Erfurt_Syntax_RDFSerializer();
			
			// send rdf/xml content type header
			header('Content-Type: application/rdf+xml');

			return $rdfSerializer->serializeToString($xmlWriter, $m);
			
		} elseif ($fileType == '.n3') {
			
			$serializer = new N3Serializer();
			
			// send text/rdf+n3 type headers
			header('Content-Type: text/rdf+n3');
			
			return $serializer -> serialize($m);
			
		} else {
			
			return false;
			
		}
			
	}

}
?>
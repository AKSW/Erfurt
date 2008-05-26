<?php
require_once 'Erfurt/Rdf/Node.php';

class Erfurt_Rdf_Resource extends Erfurt_Rdf_Node {
	
	protected $_namespace = false;
	protected $_localName = false;
	
	protected function __construct($namespace, $localName) {
		
		$this->_namespace = $namespace;
		$this->_localName = $localName;
	}
	
	public static function initWithNamespaceAndLocalName($namespace, $localName) {
		
		return new Erfurt_Rdf_Resource($namespace, $localName);
	}
	
	public static function initWithIri($uri) {
		
		return new Erfurt_Rdf_Resource(false, $uri);
	}
	
	/**
	 * @throws Erfurt_Exception
	 */ 
	public static function initWithQName($qname) {
		
	}
	
	public static function initWithBlankNodeId($id) {
		
		return new Erfurt_Rdf_Resource('_', $id);
	}
	
	/**
	 * @throws Erfurt_Exception
	 */
	public function getUri() {
		
		// check whether the localname contains the full uri (namespace = false)
		if (!$this->_namespace) {
			return $this->_localName;
		}
		// check whether this is a blank node (localname = '_')
		else if ($this->isBlankNode()) {
// TODO code
			require_once 'Erfurt/Exception.php';
			throw new Erfurt_Exception('resource is a blank node; use getId or getLabel instead');	
		}	
		// else return the concatenation of namespace and localname	
		else {
			return ($this->_namespace . $this->_localName);
		}	
	}
	
	/**
	 * @throws Erfurt_Exception
	 */
	public function getId() {
		
		if (!$this->isBlankNode()) {
// TODO code
			require_once 'Erfurt/Exception.php';
			throw new Erfurt_Exception('resource is not a blank node, use getUri or getLabel instead');
		} else {
			return ($this->_namespace . ':' . $this->_localName);
		}
	}
	
	public function getLabel() {
		
		$label = null;
		try {
			// this will fail iff this is a blanknode
			$label = $this->getUri();
		} catch (Exception $e) {
			$label = $this->getId();
		}
		
		return $label;
	}
	
	public function isBlankNode() {
		
		if ($this->_namespace === '_') {
			return true;
		} else {
			return false;
		}
	}
	
	public function isUri() {
		
		return !$this->isBlankNode();
	}
}
?>

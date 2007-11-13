<?php

/**
  * RDFS Model for OpenLink Virtuoso Backend <http://virtuoso.openlinksw.com/>
  *
  * @package rdfs
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
class RDFSModel extends Erfurt_Rdfs_Model_Abstract {
	
	public $baseUri;
	
	public function load($file, $type = null, $stream = false) {
		// if (!$stream) {
			$this->store->importStatements($file, $type, $this->modelURI, $this->baseUri);
		// } else {
			// TODO: streaming not supported yet
		// }
	}
	
	protected function _createStatement($subj, $pred = false, $obj = false, $objLang = '', $objDType = '') {
		
	}
	
	public function add($subj, $pred = '', $obj = '') {
		
	}
	
	public function remove($subj, $pred = '', $obj = '') {
		
	}
	
	public function getType() {
		if ($this->askSparql('
			ASK WHERE {
				<' . $this->modelURI . '> a <' . EF_OWL_NS . 'Ontology>.
			}')) {
			
			return 'OWL';
		}
		return 'RDFS';
	}
	
	public function _dbId($resource) {
		
	}
	
	public function getParsedNamespaces() {
		return array();
	}
	
	public function listNamespaces() {
		
	}
	
	public function listDatatypes() {
		
	}
	
	public function listLanguages() {
		
	}
	
	protected function _listResourcesCol($col, $search = '', $start = 0, $count = 0, $erg = 0) {
		return array();
	}
	
	public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false, $hiddenClasses = false) {
		// $sparql = '
		// 	SELECT DISTINCT(?c)
		// 	WHERE {{
		// 		?s <' . EF_RDFS_NS . 'subClassOff> ?c.
		// 		?t <' . EF_RDFS_NS . 'subClassOff> ?t.
		// 		}';
		// 
		// if ($emptyClasses) {
		// 	// onyl classes that appear as a type (i.e. have instances)
		// 	$sparql .= '
		// 		UNION
		// 		{?i <' . EF_RDF_NS . 'type> ?c.}'; 
		// }
		// 
		// if ($implicitClasses) {
		// 	// only explicitly defined classes
		// 	$sparql .= '
		// 		UNION
		// 		{?c <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Class>.}
		// 		UNION
		// 		{?c <' . EF_RDF_NS . 'type> <' . EF_RDFS_NS . 'Class>.}';
		// }
		// 
		// $sparql .= 'FILTER (!BOUND(?t))}';
		
		$sparql = '
			SELECT DISTINCT ?class
			WHERE {
				{ ?class a ?x .
				OPTIONAL { ?class <' . EF_RDFS_NS . 'subClassOf> ?super1 . } .
				OPTIONAL { ?class <http://ns.ontowiki.net/SysOnt/hidden> ?h } . 
				FILTER (?x = <' . EF_OWL_NS . 'Class> || ?x = <' . EF_OWL_NS . 'DeprecatedClass> || ?x = <' . EF_RDFS_NS . 'Class>) .
				FILTER (!bound(?super1) && !isBlank(?class) ) . ' .
				(($hiddenClasses == false) ? ' FILTER ( !bound(?h) || ?h != "true") . ' : '') .
				(($systemClasses == false) ? 
				'FILTER (!regex(str(?class), "(' . EF_OWL_NS . '|' . EF_RDFS_NS . '|' . EF_RDF_NS . ').*")) . ' 
				: '') .
				'}' . (($implicitClasses == true) ? 
				' UNION
				{ ?implr a ?class . 
				OPTIONAL { ?class <' . EF_RDFS_NS . 'subClassOf> ?super2 . } .
				OPTIONAL { ?class <http://ns.ontowiki.net/SysOnt/hidden> ?h } .
				FILTER ( !bound(?super2) && !isBlank(?implr) ) . ' .
				(($hiddenClasses == false) ? ' FILTER ( !bound(?h) || ?h != "true") . ' : '') .
				(($systemClasses == false) ? 
				'FILTER (!regex(str(?class), "(' . EF_OWL_NS . '|' . EF_RDFS_NS . '|' . EF_RDF_NS . ').*") ) . ' 
				: '') .
				'}
				 }' : '}');
		
		$result = $this->sparqlQuery($sparql);
		
		$classes = array();
		foreach ($result as $row) {
			$classes[] = $this->classF($row['class']);
		}
		
		return $classes;
	}
	
	public function hasStatement($s, $p, $o) {
		return $this->sparqlAsk('
			ASK WHERE {
				<' . $s->getURI() . '> <' . $p->getURI() . '> <' . $o->getURI() . '>.
			}');
	}
	
	public function listClassLabelLanguages() {
		
	}
	
	public function listInstances($start = 0, $erg = 0, $end = 0) {
		
	}
	
	public function listClassAnnotationProperties() {
		
	}
	
	public function findStatement($s, $p, $o) {
		return array();
	}
	
	public function findAsMemModel($s, $p, $o, $offset = 0, $limit = 0, $erg = 0) {
		
	}
	
	public function findSubjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
		return array();
	}
	
	public function findObjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
		return array();
	}
	
	public function findPredicates($subject = null, $object = null) {
		return array();
	}
	
	public function findInstances($properties = array(), $compare = 'exact', $offset = 0, $limit = 0, $erg = 0) {
		$sparql = '
			SELECT ?instance
			WHERE {
				?instance a ?type.
			}';
		
		return $this->sparqlQuery($sparql);
	}
	
	public function findNodesAs($subject, $predicate, $object, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
		return array();
	}
	
	public function getListAs($idOrRest, $class = null) {
		
	}
	
	public function search($search, $where, $compare, $offset = 0, $limit = 0) {
		
	}
	
	public function searchFullText($search, $type = null, $offset = 0, $limit = 10000, $erg = 0) {
		
	}
	
	public function logStart($action, $subject = '', $details = '') {
		
	}
	
	public function logEnd() {
		
	}
	
	public function logEnabled() {
		
	}
	
	public function renameNamespace($fromNS, $toNS) {
		
	}
	
	public function removeDuplicateStatements() {
		
	}
	
	public function listLists() {
		$sparql = '
			SELECT ?list 
			WHERE {
				?list a <' . EF_RDF_NS . 'list>.
			}';
		
		return $this->sparqlQuery($sparql);
	}
	
	public function sparqlQuery($query) {
		return $this->store->executeSparql($this, $query);
	}
	
	public function sparqlAsk($query) {
		return $this->store->askSparql($this, $query);
	}
}

?>

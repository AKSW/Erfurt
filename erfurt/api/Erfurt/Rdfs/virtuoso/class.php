<?php

/**
  * RDFS Class for OpenLink Virtuoso Backend <http://virtuoso.openlinksw.com/>
  *
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
class RDFSClass extends Erfurt_Rdfs_Class_Abstract {
	
	public function listDirectSubClasses($emptyClasses = false, $hiddenClasses = true) {
		if (!$emptyClasses) {
			// filter for classes that have instances
			$emptyFilter = '
				FILTER (ASK {
					?x <' . EF_RDF_NS . 'type> ?subclass
				})';
		}
		if (!$hiddenClasses) {
			// filter for un-hidden classes
			$hiddenFilter = '
				FILTER (!ASK {
					?subclass SysOnt:hidden "true".
				})';
		}
		$sparql = '
			SELECT DISTINCT(?subclass)
			WHERE {
				?subclass <' . EF_RDFS_NS . 'subClassOf> <' . $this->uri . '>
			}';
		
		$result = $this->model->sparqlQuery($sparql);
		$classes = array();
		
		if (is_array($result) && !empty($result)) {
			foreach ($result as $row) {
				// instantiate classes
				$classes[] = $this->model->classF($row['subclass']);
			}
		}
		
		return $classes;
	}
	
	public function listInstancePropertyValues($property, $resourcesOnly = true) {
		return array();
	}
	
	public function countInstancePropertyValues($property, $resourcesOnly = true, $minDistinctValues = 0) {
		
	}
	
	public function countInstancesOfSubclasses() {
		
	}
	
	public function listInstanceLabelLanguages() {
		return array();
	}
	
	public function listInstanceLabels($language) {
		return array();
	}
	
	public function findInstances($properties = array(), $compare = 'exact', $start = 0, $count = 0, $erg = 0) {
		$sparql = '
			SELECT ?i
			WHERE {
				?i a <' . $this->uri . '>.
			}';
		
		$result    = $this->model->sparqlQuery($sparql);
		$instances = array();
		
		if (is_array($result) && !empty($result)) {
			foreach ($result as $row) {
				$instances[] = $this->model->resourceF($row['i']);
			}
		}
		
		return $instances;
	}
	
	public function findInstancesRecursive($properties = array(), $compare = 'exact', $offset = 0, $limit = 0, $erg = 0) {
		$sparql = '
			SELECT ?i
			WHERE {{
				?i a <' . $this->uri . '>.
			}
			UNION {
				?i a ?a.
				?a <' . EF_RDFS_NS . 'subClassOf> <' . $this->uri . '>.
			}}';
		
		$result    = $this->model->sparqlQuery($sparql);
		$instances = array();
		
		if (is_array($result) && !empty($result)) {
			foreach ($result as $row) {
				$instances[] = $this->model->resourceF($row['i']);
			}
		}
		
		return $instances;
	}
	
	public function listDirectProperties() {
		return array();
	}
	
	public function listSuperClasses() {
		$sparql = '
			SELECT ?superclass
			WHERE { ' . 
				$this->uri . ' <' . EF_RDFS_NS . 'subClassOf> ?superclass.
			}';
		
		return $this->model->sparqlQueryAs($sparql, 'RDFSClass');
	}
	
	public function listPropertiesUsed() {
		$sparql = '
			SELECT ?property
			WHERE { 
				?x ?property ?y.
				?x <' . EF_RDFS_NS . 'type> ' . $this->uri . '.
			}';
		
		return $this->model->sparqlQueryAs($sparql, 'RDFSProperty');
	}
	
	public function listPropertiesUsedRecursive() {
		return array();
	}
	
	public function countInstances() {
		$sparql = '
			SELECT count(?instance)
			WHERE { 
				?instance <' . EF_RDFS_NS . 'type> <' . $this->uri . '>.
			}';
		
		if ($result = $this->model->sparqlQuery($sparql)) {
			return $result[0][0];
		}
	}
	
	public function countInstancesRecursive() {
		$sparql = '
			SELECT count(?instance)
			WHERE { 
				{?instance a <' . $this->uri . '>.}
				UNION {
					?instance a ?a.
					?a <' . EF_RDFS_NS . 'subClassOf> <' . $this->uri . '>.
				}
				
			}';
		
		if ($result = $this->model->sparqlQuery($sparql)) {
			return $result[0]['callret-0'];
		}
	}
	
	protected function _listInheritedProperties($propertyUris) {
		return array();
	}
}

?>
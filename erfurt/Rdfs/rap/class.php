<?php
/**
 * Class that represents an RDFS ontology node characterising a class description.
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: class.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class RDFSClass extends DefaultRDFSClass {
	function findInstances($properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		$args=func_get_args();
		$c=cache('findInstances'.$this->model->modelURI.$this->getURI(),$args);
		if($c!==NULL)
			return $c;

		if(!$properties)
			return $this->listInstances($start,$count,&$erg);
		$ret=array();

		$sql='SELECT s.subject,s.subject_is FROM statements s';
		$n=0;
		if($properties['localName']) {
			$where.=' AND s.subject LIKE "'.$this->model->baseURI.$properties['localName'].'%"';
			unset($properties['localName']);
		}
		foreach($properties as $property=>$value) {
			$prop=$this->model->resourceF($property);
			$sql.=($value?' INNER ':' LEFT ');
			$n++;
			if(!$value)
				$cond='1';
			else if($compare=='exact')
				$cond="s$n.object='".(is_a($value,'Resource')?$this->model->_dbId($value):$value)."'";
			else if($compare=='starts')
				$cond="s$n.object LIKE '$value%'";
			else if($compare=='contains')
				$cond="s$n.object LIKE '%$value%'";
			else if($compare=='regex')
				$cond="s$n.object REGEXP '$value'";
			else if($compare=='empty')
				$cond="ISNULL(s$n.object)";

			$sql.='JOIN statements s'.$n." ON(s.modelID=s$n.modelID AND s.subject=s$n.subject AND s$n.predicate='".$this->model->_dbId($prop)."' AND $cond)";
			if(!$value)
				$where.=" AND ISNULL(s$n.object)";
		}
		$sql.=' WHERE s.modelID IN ('.$this->model->getModelIds().') AND s.predicate=\''.$this->model->_dbId('RDF_type').'\'
			AND s.object=\''.$this->model->_dbId($this).'\''.(!empty($where)?$where:'').' GROUP BY s.subject';
#print_r($sql);
		if($count)
			$res=&$this->model->dbConn->PageExecute($sql,$count,$start/$count+1);
		else
			$res=&$this->model->dbConn->execute($sql);

		$erg=$res->_maxRecordCount?$res->_maxRecordCount:$res->_numOfRows;

		$ret=$this->model->_convertRecordSetToNodeList($res,$this->model->instance);
		cache('findInstances'.$this->model->modelURI.$this->getURI(),$args,$ret);
		return $ret;
	}
	function listDirectProperties() {
		static $unionCache;
		$ret=$this->model->findNodes(NULL,$GLOBALS['RDFS_domain'],$this,'Property');
		foreach($ret as $property)
			$ret=array_merge($ret,$property->listSubProperties());
		if(!$unionCache) {
			$unionCache=array();
			foreach($this->model->rdqlQuery("SELECT * WHERE (?x,<rdfs:domain>,?y) (?y,<owl:unionOf>,?z)") as $row) {
				foreach(array_keys($this->model->getList($row['?z'])) as $dom)
					$unionCache[$dom][$row['?x']->getLocalName()]=$this->model->getProperty($row['?x']->getURI());
			}
		}
		if(!empty($unionCache[$this->getLocalName()]))
			$ret=array_merge($ret,$unionCache[$this->getLocalName()]);
		return array($this->getLocalName()=>$ret);
	}
	function _listInheritedProperties($propertyURIs) {
		$c=cache('listInheritedProperties'.$this->model->modelURI.$this->getURI());
		if($c!==NULL)
			return $c;
		$ret=array();
		if(!$superclasses=method_exists($this,'listSuperClassesInfered')?$this->listSuperClassesInfered():$this->listSuperClasses()) {
			// get Properties at OWL_Thing
			$ret=array('owl:Thing'=>$this->model->findNodes(NULL,$GLOBALS['RDFS_domain'],$GLOBALS['OWL_Thing'],'Property'));
			// get properties with domain not defined
			$sql="SELECT s1.subject,s1.subject_is,s2.predicate
				FROM statements s1 LEFT JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
					AND (s2.predicate='".$this->model->_dbId('RDFS_domain')."' OR s2.predicate='".$this->model->_dbId('RDFS_subPropertyOf')."'))
				WHERE s1.predicate='".$this->model->_dbId('RDF_type')."' AND s1.object IN ('".join("','",$propertyURIs)."')
					AND s1.modelID IN (".$this->model->getModelIds().")
				HAVING ".$this->model->dbConn->IfNull("s2.predicate","'_pwlnull'")."='_pwlnull'";
			$ret['owl:Thing']=$this->model->_convertRecordSetToNodeList($this->model->dbConn->execute($sql),$this->model->property);
		}
		$done=array();
		foreach($superclasses as $sckey=>$sc) {
			foreach($sc->listProperties() as $class=>$props)
				foreach($props as $prop=>$val) {
					if(!in_array($prop,$done)) {
						$ret[$class][$prop]=$val;
						$done[$prop]=$prop;
					}
				}
		}
		cache('listInheritedProperties'.$this->model->modelURI.$this->getURI(),array(),$ret);
		return $ret;
	}
	function listSuperClasses() {
#		return $this->listPropertyValues($GLOBALS['RDFS_subClassOf'],'Class'); # <- returns bNodes
		$sql="SELECT object,object_is FROM statements WHERE subject='".$this->getURI()."'
			AND predicate='".$this->model->_dbId('RDFS_subClassOf')."' AND object_is='r' AND modelID IN (".$this->model->getModelIds().')';
		return $this->model->_convertRecordSetToNodeList($this->model->dbConn->execute($sql),$this->model->vclass);
	}
	function listPropertiesUsed() {
		$sql="SELECT s1.predicate
			FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
				AND s1.predicate!='".$this->model->_dbId('RDF_type')."'
				AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
			WHERE s1.modelID IN (".$this->model->getModelIds().")
			GROUP BY s1.predicate";
		return $this->model->_convertRecordSetToNodeList($sql,'RDFSProperty');
	}
	function countInstances() {
		$sql="SELECT COUNT(modelID) FROM statements WHERE modelID IN (".$this->model->getModelIds().")
			AND predicate='".$this->model->_dbId('RDF_type')."' AND object='".$this->model->_dbId($this)."'";
		$count=$this->model->dbConn->getOne($sql);
		return $count?$count:0;
	}
	
	/**
	 * Counts all direct instances and all instances of all subclasses.
	 * 
	 * @return int Returns the number of instances of this class and its subclasses.
	 */
	public function countInstancesRecursive() {
		
		$count = $this->countInstances();
		$subclasses = $this->listSubClasses();
		
		if (count($subclasses) === 0) return $count;
		else {
			foreach ($subclasses as $s) $count += $s->countInstancesRecursive();
		}
		
		return $count;
	}
	
}
?>
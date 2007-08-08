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
	
#######################################################################################################################
#######################################################################################################################
## 
## methods that have to be overwritten for a specific backend
##	
#######################################################################################################################
#######################################################################################################################

	/**
	 * @see DefaultRDFSClass
	 */
	public function listDirectSubClasses($emptyClasses = false) {
	    
	    $sql = 'SELECT DISTINCT s.subject, s.subject_is
	            FROM statements s
	            WHERE modelID IN (' . $this->model->getModelIds() . ') AND
	            s.predicate = "' . $this->model->_dbId('RDFS_subClassOf') . '" AND 
	            s.object = "' . $this->model->_dbId($this) . '"
	            GROUP BY s.subject
	            ORDER BY s.subject';
	            
	    $subClasses = $this->model->_convertRecordSetToNodeList($sql, $this->model->vclass);
	    
	    if (!$emptyClasses) {
	        $temp = $subClasses;
            $subClasses = array();
            
            foreach ($temp as $t) {
                if (!$t->isEmpty(true)) $subClasses[] = $t;
            }
	    }
	      
	    return $subClasses;
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function listInstancePropertyValues($property,$resourcesOnly=true) {
		
		$sql="SELECT DISTINCT s1.object,s1.object_is,s1.l_language,s1.l_datatype
			FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
				AND s1.predicate='".$this->model->_dbId($property)."'
				AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
			WHERE s1.modelID IN (".$this->model->getModelIds().")".($resourcesOnly?" AND s1.object_is='r'":'');
#print_r($sql);
		return $this->model->_convertRecordSetToNodeList($sql);
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function countInstancePropertyValues($property,$resourcesOnly=true,$minDistinctValues=0) {
		
		if($minDistinctValues>1)
			$sql="SELECT SUM(b) FROM (SELECT 1 as b
					FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
						AND s1.predicate='".$this->model->_dbId($property)."'
						AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
					WHERE s1.modelID IN (".$this->model->getModelIds().")".
						($resourcesOnly?" AND s1.object_is='r'":'').
					'GROUP BY s1.object,s1.object_is,s1.l_language,s1.l_datatype HAVING COUNT(*)>='.$minDistinctValues.') c';
		else
			$sql="SELECT COUNT(DISTINCT s1.object,s1.object_is,s1.l_language,s1.l_datatype)
				FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
					AND s1.predicate='".$this->model->_dbId($property)."'
					AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")".
					($resourcesOnly?" AND s1.object_is='r'":'');
#print_r($sql);
		$ret=$this->model->dbConn->getOne($sql);
#		foreach($this->listSubClasses() as $cl)
#			$ret+=$cl->countInstancePropertyValues($property,$resourcesOnly);
		return $ret;
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function countInstancesOfSubclasses() {
		
		$count=0;
		$subclasses=array();
		foreach($this->listSubClasses() as $subclass) {
			$subclasses[]=$subclass->getURI();
			$count+=$subclass->countInstancesOfSubclasses();
		}
		if($subclasses) {
			$subclassSQL=join('\',\'',$subclasses);
			$sql="SELECT COUNT(s1.modelID) FROM statements s1 INNER JOIN statements s2
					ON(s2.modelID IN (".$this->model->getModelIds().") AND s1.subject=s2.object AND s1.object_is=s2.object_is)
				WHERE
					s1.modelID IN (".$this->model->getModelIds().")
					AND s1.predicate='".$this->model->_dbId('RDFS_subClassOf')."' AND s1.object='".$this->model->_dbId($this)."'
					AND s2.predicate='".$this->model->_dbId('RDF_type')."'";
			$count+=$this->model->dbConn->getOne($sql);
		}
		return $count;
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function listInstanceLabelLanguages() {
		
		$sql="SELECT s1.l_language
		      FROM statements s1 INNER JOIN statements s2
		         ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s1.predicate='".$this->model->_dbId('RDFS_label')."'
		            AND s2.predicate='".$this->model->_dbId('RDF_type')."'
		            AND s2.object='".$this->model->_dbId($this)."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")
		      GROUP BY s1.l_language";
		return $this->model->dbConn->getCol($sql);
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function listInstanceLabels($language) {
		
		$sql="SELECT s1.object,s3.object,s4.object,s5.object
		      FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s1.predicate='".$this->model->_dbId('RDFS_label')."'
		            AND s1.l_language='".$language."'
		            AND s2.predicate='".$this->model->_dbId('RDF_type')."'
		            AND s2.object='".$this->getURI()."')
				INNER JOIN statements s3 ON(s1.subject=s3.subject AND s1.modelID=s3.modelID
					AND s3.predicate='".Zend_Registry::get('erfurt')->getStore()->SysOnt->baseURI.'labelText'."')
				LEFT JOIN statements s4 ON(s1.subject=s4.subject AND s1.modelID=s4.modelID
		            AND s4.predicate='".$this->model->_dbId('RDFS_comment')."'
		            AND s4.l_language='".$language."')
				LEFT JOIN statements s5 ON(s1.subject=s5.subject AND s1.modelID=s5.modelID
		            AND s5.predicate='".$this->model->_dbId('RDFS_seeAlso')."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")";
		$ret=array();
		foreach($this->model->dbConn->getAll($sql) as $row)
			$ret[$row[1]]=array($row[0],$row[2],$row[3]);
		return $ret;
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function findInstances($properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		
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
				$cond="s$n.object='".(($value instanceof Resource)?$this->model->_dbId($value):$value)."'";
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
	
	
	
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function findInstancesRecursive($properties = array(), $compare = 'exact', $offset = 0, $limit = 0, $erg = 0) {
		
		$args = func_get_args();
		$cache = new stmCache('findInstancesRecursive', $args, $this->model, $this);
		if ($cache->value !== null) {
			$erg = $cache->value[0];
			return $this->model->_convertRecordSetToNodeList($cache->value[1], 'instance');
		}

		$ret = array();

		$sql = 'SELECT s.subject, s.subject_is FROM statements s';
		$where = '';
		$n = 0;
		
		if (isset($properties['localName'])) {
			$where .= ' AND s.subject LIKE "' . $properties['localName'] . '%"';
			unset($properties['localName']);
		}
		
		foreach($properties as $property=>$value) {
			$prop = $this->model->resourceF($property);
			$sql .= ($value ? ' INNER ' : ' LEFT ');
			$n++;
			
			if (!$value) {
				$cond = '1';
			} else if ($compare === 'exact') {
				$cond = '(s' . $n . '.object = "' . $this->model->_dbId($value) . '" OR s' . $n . '.object = "' . $value . '")';
			} else if ($compare === 'starts') {
				$cond = 's' . $n . '.object LIKE "' . $value . '%"';
			} else if ($compare === 'contains') {
				$cond = 's' . $n . '.object LIKE "%' . $value . '%"';
			} else if ($compare === 'regex') {
				$cond = 's' . $n . '.object REGEXP "' . $value . '"';
			} else if ($compare === 'empty') {
				$cond = 'ISNULL(s' . $n . '.object)';
			}
				
			$sql .= 'JOIN statements s' . $n . ' ON (s.modelID = s' . $n . '.modelID AND s.subject = s' . $n . '.subject ' .
						'AND s' . $n . '.predicate = "' . $this->model->_dbId($prop) . '" AND ' . $cond . ')';
			
			
			
						
			if (!$value) {
				$where .= ' AND ISNULL(s' . $n . '.object)';
			}		
		}
		
		$subClasses = $this->listSubClassesRecursive();
		$subClassesIds = $this->model->_dbIds($subClasses);
		$subClassesSql = join('", "', $subClassesIds);
		

		$sql .= ' WHERE s.modelID IN (' . $this->model->getModelIds() . ') AND s.predicate = "' . $this->model->_dbId('RDF_type') . '" ' .
					'AND s.object IN ("' . $this->model->_dbId($this) . '", "' . $subClassesSql . '")';
		
		$sql .= (!empty($where)) ? $where : '';
		$sql .= ' GROUP BY s.subject';
		
		if ($limit) {
			$res = &$this->model->dbConn->PageExecute($sql, $limit, $offset/$limit+1);
		} else {
			$res = &$this->model->dbConn->execute($sql);
		}
			
		$erg = ($res->_maxRecordCount) ? $res->_maxRecordCount : $res->_numOfRows;
		$resArr = $res->getArray();

		$c = array($erg, $resArr);

		$cache->set($c, array_merge(array('rdf:type'), array_keys($properties)));
		$ret = $this->model->_convertRecordSetToNodeList($resArr, $this->model->instance);

		return $ret;
	}
	
#######################################################################################################################
#######################################################################################################################
## 
## METHODS THAT ARE OVERWRITTEN FOR PERFORMANCE REASONS
##	
#######################################################################################################################
#######################################################################################################################

	/**
	 * @see DefaultRDFSClass
	 */
	public function listDirectProperties() {
		
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
	
	/**
	 * @see DefaultRDFSClass
	 */
	protected function _listInheritedProperties($propertyURIs) {
		
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
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function listSuperClasses() {

#		return $this->listPropertyValues($GLOBALS['RDFS_subClassOf'],'Class'); # <- returns bNodes
		$sql="SELECT object,object_is FROM statements WHERE subject='".$this->getURI()."'
			AND predicate='".$this->model->_dbId('RDFS_subClassOf')."' AND object_is='r' AND modelID IN (".$this->model->getModelIds().')';
		return $this->model->_convertRecordSetToNodeList($this->model->dbConn->execute($sql),$this->model->vclass);
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function listPropertiesUsed() {
		
		$sql="SELECT s1.predicate
			FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
				AND s1.predicate!='".$this->model->_dbId('RDF_type')."'
				AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
			WHERE s1.modelID IN (".$this->model->getModelIds().")
			GROUP BY s1.predicate";
		return $this->model->_convertRecordSetToNodeList($sql,'RDFSProperty');
	}
	
	/**
	 * @see DefaultRDFSClass
	 */
	public function countInstances() {
		
		$sql="SELECT COUNT(modelID) FROM statements WHERE modelID IN (".$this->model->getModelIds().")
			AND predicate='".$this->model->_dbId('RDF_type')."' AND object='".$this->model->_dbId($this)."'";
		$count=$this->model->dbConn->getOne($sql);
		return $count?$count:0;
	}
}
?>

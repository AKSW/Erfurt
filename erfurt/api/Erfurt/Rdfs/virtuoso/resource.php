<?php

/**
  * RDFS Resource for OpenLink Virtuoso Backend <http://virtuoso.openlinksw.com/>
  *
  * @package rdfs
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
class RDFSResource extends Erfurt_Rdfs_Resource_Abstract {
	
	public function definingModels() {
		return '';
	}
	
	public function listLiteralPropertyValues($property, $lang = null, $type = null) {
		if ($property instanceof RDFSProperty) {
			$propertyUri = $property->getUri();
		} else {
			$propertyUri = $property;
		}
		
		$sparql = '
			SELECT DISTINCT(?l)
			WHERE {
				<' . $this->uri . '> <' . $propertyUri . '> ?l.';
		
		if ($lang) {
			$sparql .= '
				FILTER (LANG(?l) =  "' . $lang . '")';
		}
		if ($type) {
			$sparql .= '
				FILTER (DATATYPE(?l) = <' . $type . '>)';
		}
		
		$sparql .= '}';
		
		$resultArray = array();
		if ($result = $this->model->sparqlQuery($sparql)) {
			foreach ($result as $row) {
				$resultArray[] = $this->model->literalF($row['l']);
			}
			
			return $resultArray;
		}
	}
	
	public function getLiteralPropertyValue($property, $lang = null, $type = null) {
		if ($property instanceof RDFSProperty) {
			$propertyUri = $property->getUri();
		} else {
			$propertyUri = $property;
		}
		
		$sparql = '
			SELECT DISTINCT(?l)
			WHERE {
				<' . $this->uri . '> <' . $propertyUri . '> ?l.';
		
		if ($lang) {
			$sparql .= '
				FILTER (LANG(?l) =  "' . $lang . '")';
		}
		if ($type) {
			$sparql .= '
				FILTER (DATATYPE(?l) = <' . $type . '>)';
		}
		
		$sparql .= '}';
		
		if ($result = $this->model->sparqlQuery($sparql)) {
			return $this->model->literalF($result[0]['l']);
		}
	}
	
	public function getComment($language = null) {
		
	}
	
	public function isClass() {
		$sparql = '
			ASK WHERE {
				{?i a <' . $this->uri . '>.}
				UNION
				{<' . $this->uri . '> a <' . EF_OWL_NS . 'Class>.}
				UNION
				{<' . $this->uri . '> a <' . EF_RDFS_NS . 'Class>.}
				UNION
				{<' . $this->uri . '> <' . EF_RDFS_NS . 'subClassOf> ?super.}
				UNION
				{?sub <' . EF_RDFS_NS . 'subClassOf> <' . $this->uri . '>.}				
			}';
		
		return $this->model->sparqlAsk($sparql);
	}
}

?>

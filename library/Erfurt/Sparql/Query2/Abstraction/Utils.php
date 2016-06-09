<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * OntoWiki QUery Abstraction Utils
 * 
 * @package    Erfurt_Sparql_Query2_Abstraction
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_Abstraction_Utils 
{
	static function getAllProperties(Erfurt_Sparql_Query2_Abstraction_RDFSClass $class){
		$query = "PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#> \
			PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>\
			SELECT DISTINCT ?property ?label ?order ?range\
			WHERE {\
				?property a <http://www.w3.org/2002/07/owl#DatatypeProperty> . \
				?property rdfs:domain ?type . \
				?property rdfs:label ?label . \
				?property rdfs:range ?range . \
				OPTIONAL { \
					?property <http://ns.ontowiki.net/SysOnt/order> ?order \
				} \
				FILTER(sameTerm(?type, <".$class->iri.">))";
				
			//TODO ...
;
	}
}
?>

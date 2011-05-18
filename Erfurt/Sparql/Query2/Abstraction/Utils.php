<?php
/**
 * OntoWiki QUery Abstraction Utils
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Utils.php 3977 2009-08-09 14:38:37Z jonas.brekle@gmail.com $
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

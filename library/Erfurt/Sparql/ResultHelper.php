<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * This class provides functions to edit a sparql query result.
 *
 * @package    Erfurt_Sparql
 * @author     Konrad Abicht <konrad@inspirito.de>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_ResultHelper 
{
    /**
     * Collection of popular namespaces in OntoWiki
     */
    public static $namespaces = array (
        'http://www.w3.org/1999/02/22-rdf-syntax-ns#'       => 'rdf:',
        'http://www.w3.org/2000/01/rdf-schema#'             => 'rdfs:',
        'http://purl.org/dc/elements/1.1/'                  => 'dc:',
        'http://purl.org/dc/terms/'                         => 'dcterms:',
        'http://usefulinc.com/ns/doap#'                     => 'doap:',
        'http://data.lod2.eu/scoreboard/indicators/'        => 'ind:',
        'http://www.w3.org/2002/07/owl#'                    => 'owl:',
        'http://data.lod2.eu/scoreboard/properties/'        => 'prop:',
        'http://purl.org/NET/scovo#'                        => 'scovo:',
        'http://rdfs.org/sioc/ns#'                          => 'sioc:',
        'http://www.w3.org/2004/02/skos/core#'              => 'skos:',
        'http://purl.org/linked-data/sdmx#'                 => 'sdmx:',
        'http://purl.org/linked-data/sdmx/2009/dimension#'  => 'sdmx-dimension:',
        'http://purl.org/linked-data/sdmx/2009/metadata#'   => 'sdmx-metadata:',
        'http://ns.ontowiki.net/SysOnt/'                    => 'sys-ont:',
        'http://purl.org/linked-data/cube#'                 => 'qb:',
        'http://www.w3.org/2001/XMLSchema#'                 => 'xsd:'
    );
    
    /**
     * This function try to replace the namespace url in a given string with the related key, based on 
     * the $_namespaces property.
     * @param $nsUrl Url to replace the namespace with prefix
     * @return string Modified $nsUrl
     */
    public static function replaceNamespaceUrlWithPrefix ( $nsUrl ) {
        foreach ( Erfurt_Sparql_ResultHelper::$namespaces as $fullNsUrl => $nsPrefix ) {
            if(false !== strpos ($nsUrl, $fullNsUrl)) {
                // It assumes that there is only one namespace url to replace
                return str_replace ($fullNsUrl, $nsPrefix, $nsUrl);
            }
        }
        return $nsUrl;
    }    
    
    /**
     * Transforms a sparqlQuery result into an associative array. Subject will be main key, predicate key of
     * subelements and object is value. 
     * 
     * Result will looks like this:
     * 
     *  array (
     *      'http://foo.bar/ns#' => array ( 
     *          'http://www.w3.org/2000/01/rdf-schema#label' => 'Label of resource',
     *          ...
     *      )
     *      ...
     *  );
     * With "http://foo.bar/ns#" is subject, "http://www.w3.org/2000/01/rdf-schema#label" a predicate and 
     * "Label of resource" an object.
     * 
     * @param $sr sparqlQuery function result
     * @param $usePrefixedUrls It will use for insance rdfs: instead of the whole rdfs uri
     * @return array Associative array
     */
    public static function sparqlQueryResultToAssocArray ($sr, $usePrefixedUrls = false) {
        
        // check if $sr is empty or not an array
        if ( 0 == count ($sr) || false === is_array ($sr) ) {
            return array ();
        }
        
        $result = array ();
        
        foreach ( $sr as $triple ) {
            
            // SUBJECT
            if(true == isset($result [$triple['s']])) {
                // subject is still initialized
            } else {
                $result [$triple['s']] = array ();
            }
            
            // PREDICAATE
            $triple['p'] = true == $usePrefixedUrls
                ? Erfurt_Sparql_ResultHelper::replaceNamespaceUrlWithPrefix ( $triple['p'] )
                : $triple['p'];
            
            if(true == isset($result [$triple['s']][$triple['p']])) {
                // predicate is still initialized, so add further objects
                $result [$triple['s']][$triple['p']] [] = $triple ['o'];
            } else {
                $result [$triple['s']][$triple['p']] = array ($triple['o']);
            }
        }
        
        return $result;
    }
}

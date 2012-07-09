<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Interface.php';

/**
 * This class acts as an intermediate implementation for some important formats.
 * It uses the ARC library unitl we have own implementations.
 * 
 * @package   Erfurt_Syntax_RdfSerializer_Adapter
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Syntax_RdfSerializer_Adapter_RdfJson implements Erfurt_Syntax_RdfSerializer_Adapter_Interface
{    
    public function serializeResourceToString($resourceUri, $graphUri, $pretty = false, $useAc = true)
    {
        $triples = array();
        $store = Erfurt_App::getInstance()->getStore();
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $sparql = new Erfurt_Sparql_SimpleQuery();
        $sparql->setProloguePart('SELECT ?s ?p ?o');
        $sparql->addFrom($graphUri);
        $sparql->setWherePart('WHERE { ?s ?p ?o . FILTER (sameTerm(?s, <'.$resourceUri.'>)) }');
        $sparql->setOrderClause('?s ?p ?o');
        $sparql->setLimit(1000);
        
        $offset = 0;
        while (true) {
            $sparql->setOffset($offset);
            
            $result = $store->sparqlQuery($sparql, array(
		        'result_format'   => 'extended',
		        'use_owl_imports' => false,
		        'use_additional_imports' => false,
		        'use_ac' => $useAc
		    ));
            
            $counter = 0;
            foreach ($result['results']['bindings'] as $stm) {
                $s = $stm['s']['value'];
                $p = $stm['p']['value'];
                $o = $stm['o'];

                if (!isset($triples["$s"])) {
                    $triples["$s"] = array();
                }

                if (!isset($triples["$s"]["$p"])) {
                    $triples["$s"]["$p"] = array();
                }
                
                if ($o['type'] === 'typed-literal') {
                    $triples["$s"]["$p"][] = array(
                        'type'     => 'literal',
                        'value'    => $o['value'],
                        'datatype' => $o['datatype']
                    );
                } else if ($o['type'] === 'typed-literal') {
                    $oArray = array(
                        'type'  => 'literal',
                        'value' => $o['value']
                    );
                    
                    if (isset($o['xml:lang'])) {
                        $oArray['lang'] = $o['xml:lang'];
                    }
                    
                    $triples["$s"]["$p"][] = $oArray;
                } else {
                    $triples["$s"]["$p"][] = array(
                        'type'     => $o['type'],
                        'value'    => $o['value']
                    );
                }
                $counter++;
            }
            
            if ($counter < 1000) {
                break;
            }
            
            $offset += 1000;
        }
        
        return json_encode($triples);
    }
    
    public function serializeGraphToString($graphUri, $pretty = false, $useAc = true)
    {   
        $triples = array();
        $store = Erfurt_App::getInstance()->getStore();
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $sparql = new Erfurt_Sparql_SimpleQuery();
        $sparql->setProloguePart('SELECT ?s ?p ?o');
        $sparql->addFrom($graphUri);
        $sparql->setWherePart('WHERE { ?s ?p ?o }');
        $sparql->setOrderClause('?s ?p ?o');
        $sparql->setLimit(1000);
        
        $offset = 0;
        while (true) {
            $sparql->setOffset($offset);
            
            $result = $store->sparqlQuery($sparql, array(
		        'result_format'   => 'extended',
		        'use_owl_imports' => false,
		        'use_additional_imports' => false,
		        'use_ac' => $useAc
		    ));

            $counter = 0;
            foreach ($result['results']['bindings'] as $stm) {
                $s = $stm['s']['value'];
                $p = $stm['p']['value'];
                $o = $stm['o'];

                if (!isset($triples["$s"])) {
                    $triples["$s"] = array();
                }

                if (!isset($triples["$s"]["$p"])) {
                    $triples["$s"]["$p"] = array();
                }
                
                if ($o['type'] === 'typed-literal') {
                    $triples["$s"]["$p"][] = array(
                        'type'     => 'literal',
                        'value'    => $o['value'],
                        'datatype' => $o['datatype']
                    );
                } else if ($o['type'] === 'typed-literal') {
                    $oArray = array(
                        'type'  => 'literal',
                        'value' => $o['value']
                    );
                    
                    if (isset($o['xml:lang'])) {
                        $oArray['lang'] = $o['xml:lang'];
                    }
                    
                    $triples["$s"]["$p"][] = $oArray;
                } else {
                    $triples["$s"]["$p"][] = array(
                        'type'     => $o['type'],
                        'value'    => $o['value']
                    );
                }
                $counter++;
            }
            
            if ($counter < 1000) {
                break;
            }
            
            $offset += 1000;
        }
        
        return json_encode($triples);
    }
    
}

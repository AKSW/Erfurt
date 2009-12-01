<?php
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer.php';

/**
 * Result renderer that creates a text array
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @subpackage sparql
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: $
 */
class Erfurt_Sparql_EngineDb_ResultRenderer_Plain implements Erfurt_Sparql_EngineDb_ResultRenderer 
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
        
    protected $uriValues = array();
    protected $literalValues = array();
    
    protected $_vars = null;

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Converts the database results into the desired output format
     * and returns the result.
     *
     * @param array $arRecordSets Array of (possibly several) SQL query results.
     * @param Erfurt_Sparql_Query $query SPARQL query object
     * @param $engine Sparql Engine to query the database
     * @return array
     */
    public function convertFromDbResults($arRecordSets, Erfurt_Sparql_Query $query, $engine, $vars)
    {
        $this->query    = $query;
        $this->engine   = $engine;
        $this->_vars    = $vars;

        $strResultForm = $this->query->getResultForm();
        switch ($strResultForm) {
            case 'construct':
            case 'select':
            case 'select distinct':
                switch ($strResultForm) {
                    case 'construct':
                        $arResult = $this->_getVariableArrayFromRecordSets($arRecordSets, $strResultForm, true);
                        break;
                    default:
                        $arResult = $this->_getVariableArrayFromRecordSets($arRecordSets, $strResultForm, false);
                                              
                        if (count($this->uriValues) > 0 || count($this->literalValues) > 0) {
                            // If the query contains a ORDER BY wen need to reorder the result
                            $sm = $query->getSolutionModifier();
                            if (null !== $sm['order by']) {  
                                foreach ($sm['order by'] as $order) {
                                    $n = count($arResult);
                                    $id = ltrim($order['val'], '?$');
                                    while (true) {
                                        $hasChanged = false;
                                        
                                        for ($i=0; $i<$n-1; ++$i) {
                                            switch ($order['type']) {
                                                case 'desc':
                                                    if ($arResult[$i][$id] < $arResult[($i+1)][$id]) {
                                                        $dummy = $arResult[$i][$id];
                                                        $arResult[$i][$id] = $arResult[($i+1)][$id];
                                                        $arResult[($i+1)][$id] = $dummy;

                                                        $hasChanged = true;
                                                    }
                                                    break;
                                                case 'asc':
                                                default:
                                                    if ($arResult[$i][$id] > $arResult[($i+1)][$id]) {
                                                        $dummy = $arResult[$i][$id];
                                                        $arResult[$i][$id] = $arResult[($i+1)][$id];
                                                        $arResult[($i+1)][$id] = $dummy;

                                                        $hasChanged = true;
                                                    }
                                                    break;
                                                    
                                            } 
                                        }
                                        
                                        $n--;
                                        
                                        if (!$hasChanged && ($n === 0)) {
                                            break;
                                        }
                                    }
                                }
                            }   
                        }
                }
                
                //some result forms need more modification
                switch ($strResultForm) {
                    case 'construct';
                        $arResult = $this->_constructGraph(
                            $arResult,
                            $this->query->getConstructPattern()
                        );
                        break;
                    case 'describe';
                        $arResult = $this->describeGraph($arResult);
                        break;
                }

                return $arResult;
                break;
            case 'count':
            case 'count-distinct':
            case 'ask':
                if (count($arRecordSets) > 1) {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('More than one result set for a ' . $strResultForm . ' query!');
                }

                $nCount = 0;
                foreach ($arRecordSets[0] as $row) {
                    $nCount += intval($row['count']);
                    break;
                }

                if ($strResultForm == 'ask') {
                    return ($nCount > 0) ? true : false;
                } else {
                    return $nCount;
                }
                break;
            case 'describe':
            default:
                throw new Exception('Yet not supported: ' . $strResultForm);
        }

    }

    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructs a result graph.
     *
     * @param  array $arVartable A table containing the result vars and their bindings.
     * @param  Erfurt_Sparql_GraphPattern  $constructPattern The CONSTRUCT pattern.
     * @return array
     */
    protected function _constructGraph($arVartable, $constructPattern)
    {
        $resultGraph = array();
        
        if (!$arVartable) {
            return $resultGraph;
        }

        $tp = $constructPattern->getTriplePatterns();

        $bnode = 0;
        foreach ($arVartable as $value) {
            foreach ($tp as $triple) {
                $subVar  = substr($triple->getSubject(), 1);
                $predVar = substr($triple->getPredicate(), 1);
                $objVar  = substr($triple->getObject(), 1);
                
                $sub    = $value["$subVar"]['value'];
                $pred   = $value["$predVar"]['value'];
                $obj    = $value["$objVar"];
                
                if (!isset($resultGraph["$sub"])) {
                    $resultGraph["$sub"] = array();
                }
                
                if (!isset($resultGraph["$sub"]["$pred"])) {
                    $resultGraph["$sub"]["$pred"] = array();
                }
                
                $resultGraph["$sub"]["$pred"][] = $obj;
            }  
        }
        
        return $resultGraph;
    }
    
    protected function _createBlankNode($id)
    {
        return array(
            'type'  => 'bnode',
            'value' => $id
        );
    }
    
    protected function _createLiteral($value, $language, $datatype)
    {
        
        $retVal = array(
            'type'  => 'literal',
            'value' => $value
        );
                
        if ((null !== $language)) {
            $retVal['lang'] = $language;
        } else if ((null !== $datatype)) {
            $retVal['datatype'] = $datatype;
        }
        
        return $retVal;
    }
    
    /**
     * Creates an RDF object object contained in the given $dbRecordSet object.
     *
     * @see convertFromDbResult() to understand $strVarBase necessity
     *
     * @param array $dbRecordSet
     * @param string $strVarBase Prefix of the columns the recordset fields have.
     * @return string RDF triple object resource object.
     */
    protected function _createObjectFromDbRecordSetPart($row, $strVarBase, $strVar, $asArray = false)
    {
        $strVarName = (string)$strVar;
        
        if ($row[$this->_vars[$strVarName]['sql_value']] === null) {
            return '';
        }
        
        $result = null;
        switch ($row[$this->_vars[$strVarName]['sql_is']]) {
            case 0:
                if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
                    $result = $this->_createResource($row[$this->_vars[$strVarName]['sql_value']]);
                } else {
                    $result =  $this->_createResource(
                        $this->uriValues[$row[$this->_vars[$strVarName]['sql_ref']]]);
                }
                break;
            case 1:
                 if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
                     $result = $this->_createBlankNode($row[$this->_vars[$strVarName]['sql_value']]);
                } else {
                    $result = $this->_createBlankNode(
                        $this->uriValues[$row[$this->_vars[$strVarName]['sql_ref']]]);
                }
                break;
            default:
                 if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
                     $result = $this->_createLiteral(
                         $row[$this->_vars[$strVarName]['sql_value']], null, null);
                    
                    #if ($row[$this->_vars[$strVarName]['sql_dt_ref']] === null) {
                    #    $result = $this->_createLiteral(
                    #        $row[$this->_vars[$strVarName]['sql_value']],
                    #        $row[$this->_vars[$strVarName]['sql_lang']],
                    #        $row[$this->_vars[$strVarName]['sql_type']]
                    #    );
                    #} else {
                    #    $result = $this->_createLiteral(
                    #        $row[$this->_vars[$strVarName]['sql_value']],
                    #        $row[$this->_vars[$strVarName]['sql_lang']],
                    #        $this->uriValues[$row[$this->_vars[$strVarName]['sql_dt_ref']]]
                    #    );
                    #}
                } else {
                    $result = $this->_createLiteral(
                         $this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]], null, null);
                    
                    #if ($row[$this->_vars[$strVarName]['sql_dt_ref']] === null) {
                    #    $result = $this->_createLiteral(
                    #        $this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]],
                    #        $row[$this->_vars[$strVarName]['sql_lang']],
                    #        $row[$this->_vars[$strVarName]['sql_type']]
                    #    );
                    #} else {
                    #    $result = $this->_createLiteral(
                    #        $this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]],
                    #        $row[$this->_vars[$strVarName]['sql_lang']],
                    #        $this->uriValues[$row[$this->_vars[$strVarName]['sql_dt_ref']]]
                    #    );
                    #}
                }
        }
        
        if ($asArray) {
            return $result;
        } else {
            return $result['value'];
        }
    }

    /**
     * Creates an RDF predicate object contained in the given $dbRecordSet object.
     *
     * @see convertFromDbResult() to understand $strVarBase necessity
     *
     * @param array $dbRecordSet
     * @param string $strVarBase Prefix of the columns the recordset fields have.
     * @return string RDF triple predicate resource object.
     */
    protected function _createPredicateFromDbRecordSetPart($row, $strVarBase, $strVar, $asArray = false)
    {
        $strVarName = (string)$strVar;
        
        if ($row[$this->_vars[$strVarName]['sql_value']] === null) {
            return '';
        }
        
        $result = null;
        if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
            $result = $this->_createResource($row[$this->_vars[$strVarName]['sql_value']]);
        } else {
            $result = $this->_createResource($this->uriValues[$row[$this->_vars[$strVarName]['sql_ref']]]);
        }
    
        if ($asArray) {
            return $result;
        } else {
            return $result['value'];
        }
    }

    protected function _createResource($uri)
    {
        return array(
            'type'  => 'uri',
            'value' => $uri
        );
    }
    
    /**
     * Creates an RDF subject object contained in the given $dbRecordSet object.
     *
     * @see convertFromDbResult() to understand $strVarBase necessity
     *
     * @param array $dbRecordSet 
     * @param string $strVarBase Prefix of the columns the recordset fields have.
     * @return string RDF triple subject resource object.
     */
    protected function _createSubjectFromDbRecordSetPart($row, $strVarBase, $strVar, $asArray = false)
    {
        $strVarName = (string)$strVar;
        
        if ($row[$this->_vars[$strVarName]['sql_value']] === null) {
            return '';
        }

        $result = null;
        if ($row[$this->_vars[$strVarName]['sql_is']] === 0) {
            if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
                $result = $this->_createResource($row[$this->_vars[$strVarName]['sql_value']]);
            } else {
                $result = $this->_createResource($this->uriValues[$row[$this->_vars[$strVarName]['sql_ref']]]);
            }
        } else {
            if ($row[$this->_vars[$strVarName]['sql_ref']] === null) {
                $result = $this->_createBlankNode($row[$this->_vars[$strVarName]['sql_value']]);
            } else {
                $result = $this->_createBlankNode(
                    $this->uriValues[$row[$this->_vars[$strVarName]['sql_ref']]]);
            }
        }
        
        if ($asArray) {
            return $result;
        } else {
            return $result['value'];
        }
    }

    /**
     * Converts a result set array into an array of "rows" that
     * are subarrays of variable => value pairs.
     *
     * @param $dbRecordSet
     * @param $strResultForm
     * @return array
     */
    protected function _getVariableArrayFromRecordSet($dbRecordSet, $strResultForm, $asArray = false)
    {
        $arResult = array();
        switch ($strResultForm) {
            case 'construct':
                $arResultVars = $this->query->getConstructPatternVariables();
                break;
            default:
                $arResultVars = $this->query->getResultVars();
                break;
        }

        if (in_array('*', $arResultVars)) {
            $arResultVars = array_keys($this->_vars);
        }
        
        foreach ($dbRecordSet as $row) {
            $arResultRow = array();
            foreach ($arResultVars as $strVar) {
                $strVarName = (string)$strVar;
                $strVarId = ltrim($strVar, '?$');
                if (!isset($this->_vars[$strVarName])) {
                    //variable is in select, but not in result (test: q-select-2)
                    $arResultRow[$strVarId] = '';
                } else {
                    $arVarSettings = $this->_vars[$strVarName];
                    
                    // Contains whether variable is s, p or o.
                    switch ($arVarSettings[1]) {
                        case 's':
                            $arResultRow[$strVarId] = $this->_createSubjectFromDbRecordSetPart(
                                $row, $arVarSettings[0], $strVar, $asArray);
                            break;
                        case 'p':
                            $arResultRow[$strVarId] = $this->_createPredicateFromDbRecordSetPart(
                                $row, $arVarSettings[0], $strVar, $asArray);
                            break;
                        case 'o':
                            $arResultRow[$strVarId] = $this->_createObjectFromDbRecordSetPart(
                                $row, $arVarSettings[0], $strVar, $asArray);
                            break;
                        default:
                            require_once 'Erfurt/Exception.php';
                            throw new Erfurt_Exception('Variable has to be s, p or o.');
                    }
                }
            }
            $arResult[] = $arResultRow;
        }
        return $arResult;
    }
    
    protected function _getVariableArrayFromRecordSets($arRecordSets, $strResultForm, $asArray = false)
    {
        // First, we need to check, whether there is a need to dereference some values
        $refVariableNamesUri = array();
        $refVariableNamesLit = array();
        foreach ($this->_vars as $var) {
            if ($var[1] === 'o') {
                if (isset($var['sql_ref'])) {
                    $refVariableNamesLit[] = $var['sql_ref'];
                    $refVariableNamesUri[] = $var['sql_ref'];
                }
                if (isset($var['sql_dt_ref'])) {
                    $refVariableNamesUri[] = $var['sql_dt_ref'];
                }
            } else {
                if (isset($var['sql_ref'])) {
                    $refVariableNamesUri[] = $var['sql_ref'];
                }
            }   
        }
;
        $refVariableNamesUri = array_unique($refVariableNamesUri);
        $refVariableNamesLit = array_unique($refVariableNamesLit);

        $refIdsUri = array();
        $refIdsLit = array();
        foreach ($arRecordSets as $dbRecordSet) {
            foreach ($dbRecordSet as $row) {
                foreach ($refVariableNamesUri as $name) {
                    if ($row["$name"] !== null) {
                        $refIdsUri[] = $row["$name"];
                    }
                }
                foreach ($refVariableNamesLit as $name) {
                    if ($row["$name"] !== null) {
                        $refIdsLit[] = $row["$name"];
                    }
                }
            }
        }
 
        if (count($refIdsUri) > 0) {
            $sql = 'SELECT id, v FROM ef_uri WHERE id IN (' . implode(',', $refIdsUri) . ')';
            
            $result = $this->engine->sqlQuery($sql);
          
            foreach ($result as $row) {
                $this->uriValues[$row['id']] = $row['v'];
            }
            
        }
   
        if (count($refIdsLit) > 0) {
            $sql = 'SELECT id, v FROM ef_lit WHERE id IN (' . implode(',', $refIdsLit) . ')';
            
            $result = $this->engine->sqlQuery($sql);
            foreach ($result as $row) {
                $this->literalValues[$row['id']] = $row['v'];
            }
        }
        
        $arResult = array();
        foreach ($arRecordSets as $dbRecordSet) {
            $arResult = array_merge(
                $arResult,
                $this->_getVariableArrayFromRecordSet($dbRecordSet, $strResultForm, $asArray)
            );
        }
        return $arResult;
    }
}

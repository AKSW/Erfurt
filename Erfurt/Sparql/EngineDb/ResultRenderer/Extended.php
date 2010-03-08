<?php
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer.php';

/**
 * Result renderer that creates a PHP array containing the result of a SPARQL query as defined in
 * @link http://www.w3.org/TR/rdf-sparql-json-res/.
 *
 * @subpackage sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version	$Id: $
 */
class Erfurt_Sparql_EngineDb_ResultRenderer_Extended implements Erfurt_Sparql_EngineDb_ResultRenderer 
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
     
    protected $query    = null;
    protected $engine   = null;
    protected $_vars    = null;
        
    protected $uriValues = array();
    protected $literalValues = array();


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
            case 'select':
            case 'select distinct':
                $result = array();
                $result['head'] = $this->_getResultHeader();
                
                // incorrect format (used by erfurt for a long time so this is legacy stuff)
                $result['bindings'] = $this->_getVariableArrayFromRecordSets($arRecordSets, $strResultForm, true);
                // correct format (see http://www.w3.org/TR/rdf-sparql-json-res/)
                $result['results']['bindings'] = $this->_getVariableArrayFromRecordSets($arRecordSets, $strResultForm, true);

                return $result;
                break;
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

                $value = ($nCount > 0) ? true : false;
                
                $result = array();
                $result['head'] = $this->_getResultHeader();
                $result['boolean'] = $value;

                return $result;
                break;
            case 'construct':
            case 'count':
            case 'describe':
            default:
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Extended format not supported for:' . $strResultForm);
        }
    }

    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------

    protected function _createBlankNode($id)
    {
        return array(
            'type'  => 'bnode',
            'value' => ('_:'.$id)
        );
    }
    
    protected function _createLiteral($value, $language, $datatype)
    {

        $retVal = array(
            'type'  => 'literal',
            'value' => $value
        );
                
        if ($language !== '') {
            $retVal['xml:lang'] = $language;
        } else if ($datatype !== '') {
            $retVal['type'] = 'typed-literal';
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
            return null;
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
                     #$result = $this->_createLiteral(
                     #    $row[$this->_vars[$strVarName]['sql_value']], null, null);
                    
                    if ($row[$this->_vars[$strVarName]['sql_dt_ref']] === null) {
                        $result = $this->_createLiteral(
                            $row[$this->_vars[$strVarName]['sql_value']],
                            $row[$this->_vars[$strVarName]['sql_lang']],
                            $row[$this->_vars[$strVarName]['sql_type']]
                        );
                    } else {
                        $result = $this->_createLiteral(
                            $row[$this->_vars[$strVarName]['sql_value']],
                            $row[$this->_vars[$strVarName]['sql_lang']],
                            $this->uriValues[$row[$this->_vars[$strVarName]['sql_dt_ref']]]
                        );
                    }
                } else {
                    #$result = $this->_createLiteral(
                    #$this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]], null, null);
                    
                    if ($row[$this->_vars[$strVarName]['sql_dt_ref']] === null) {
                        $result = $this->_createLiteral(
                            $this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]],
                            $row[$this->_vars[$strVarName]['sql_lang']],
                            $row[$this->_vars[$strVarName]['sql_type']]
                        );
                    } else {
                        $result = $this->_createLiteral(
                            $this->literalValues[$row[$this->_vars[$strVarName]['sql_ref']]],
                            $row[$this->_vars[$strVarName]['sql_lang']],
                            $this->uriValues[$row[$this->_vars[$strVarName]['sql_dt_ref']]]
                        );
                    }
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
            return null;
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
            return null;
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
    
    protected function _getResultHeader()
    {
        $head = array();
        
        $resultForm = strtolower($this->query->getResultForm());
        if ($resultForm === 'ask') {
            return $head;
        } else {
            $head['vars'] = array();
            
            $arResultVars = $this->query->getResultVars(); 
            if (in_array('*', $arResultVars)) {
                $arResultVars = array_keys($this->_vars);
            }
            
            foreach ($arResultVars as $var) {
                $var = (string) $var;
                if ( $var[0] === '?' ) {
                    $head['vars'][] = substr($var,1);
                } else {
                    $head['vars'][] = $var;
                }
            }
            
            return $head;
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
        $arResultVars = $this->query->getResultVars();
        
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
                    //$arResultRow[$strVarId] = '';
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

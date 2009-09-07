<?php 

/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id:$
 */

/**
 * One-sentence description of Sparql.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package erfurt
 * @subpackage sparql
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Sparql_EngineDb_QueryOptimizer
{
    protected $_engine = null;
    
    public function __construct($engine)
    {
        $this->_engine = $engine;
    }
    
    public function optimize(Erfurt_Sparql_Query $query)
    {
        $resultForm = $query->getResultForm();

        $result = $query;
        
// TODO Not working on all queries yet.
#return $result;

        if ($resultForm === 'select distinct') {
            $result = $this->_optimizeDistinct($query);
        }
        
        return $result;
    }
    
    protected function _optimizeDistinct($query)
    {
// TODO Not supported yet.
        $sm = $query->getSolutionModifier();
        if (isset($sm['limit']) || isset($sm['offset'])) {
            return $query;
        } 
        
        
        $oldMandatory = array();
        $mandatory = array();
        $optionals = array();

        $usedVars = array();
        $optionalOnlyVars = array();
        foreach ($query->getResultPart() as $graphPattern) {
            if (null === $graphPattern->getOptional()) {
                $tempPattern = clone $graphPattern;
                $newConstraints = array();
                $vars = $tempPattern->getVariables();
                
                
                foreach ($tempPattern->getConstraints() as $c) {
                    $add = true;
                    foreach ($c->getUsedVars() as $v) {
                        if (!in_array($v, $vars)) {
                            $add = true;
                            $optionalOnlyVars[$v] = true;
                        }
                    }
                    
                    if ($add) {
                        $newConstraints[] = $c;
                    }
                }
                
                $tempPattern->setConstraints($newConstraints);
                $usedVars = array_merge($usedVars, $vars);
                $oldMandatory[$graphPattern->getId()] = $graphPattern;
                $mandatory[$graphPattern->getId()] = $tempPattern;
            } else {
                $vars = $graphPattern->getVariables();
                $addToOptionals = true;
                
                foreach ($vars as $v) {
                    if (isset($optionalOnlyVars[$v])) {
                        $mandatory[$graphPattern->getId()] = $graphPattern;
                        $addToOptionals = false;
                        break;
                    }
                }
                
                if ($addToOptionals) {
                    $optionals[$graphPattern->getId()] = $graphPattern;
                }
                
                
            }
  
        }


        if (count($optionals) === 0) {
            // We do not need to modify the query, for there won't be any joins...
            return $query;
        } 
        
        $query = clone $query;
        
        
        $resultVars = array();
        foreach ($query->getResultVars() as $varObject) {
            $resultVars[$varObject->getVariable()] = true;
        }
        
        require_once 'Erfurt/Sparql/EngineDb/SqlGenerator/Adapter/Ef.php';
        require_once 'Erfurt/Sparql/EngineDb/TypeSorter.php';
        
        
        $sg = new Erfurt_Sparql_EngineDb_SqlGenerator_Adapter_Ef($query, $this->_engine->getModelIdMapping());
        $ts = new Erfurt_Sparql_EngineDb_TypeSorter($query, $this->_engine);
        $arSqls = $sg->createSql();
        $ts->setData($sg);
        $orderifiedSqls = $ts->getOrderifiedSqls($arSqls);

        $originalVars = $sg->arVarAssignments;
#var_dump($originalVars);
        
        
        
           
        
        $usedVars = array_unique($usedVars);
        $newResultVars = array();
        
        $tempQuery = clone $query;
            
        // We need to adjust the limit, offset values.
// TODO limit offset support
        #$sm = $tempQuery->getSolutionModifier();
        #if (isset($sm['limit'])) {
        #    $tempQuery->setSolutionModifier('limit', 1000);
        #}
        #if (isset($sm['offset'])) {
        #    $tempQuery->setSolutionModifier('offset', 0);
        #}
        
        foreach ($tempQuery->getResultVars() as $var) {
            if (in_array($var->getVariable(), $usedVars)) {
                $newResultVars[] = $var;
            }
        }
        $tempQuery->setResultVars($newResultVars);
        
        
        
        $tempQuery->setResultPart($mandatory);

        // Execute the modified Sparql query.
        $sg = new Erfurt_Sparql_EngineDb_SqlGenerator_Adapter_Ef($tempQuery, $this->_engine->getModelIdMapping());
        $ts = new Erfurt_Sparql_EngineDb_TypeSorter($tempQuery, $this->_engine);
        $arSqls = $sg->createSql();
        $ts->setData($sg);
        $orderifiedSqls = $ts->getOrderifiedSqls($arSqls);
        $mandatoryResult = $this->_queryMultiple($tempQuery, $orderifiedSqls);
        $mandatoryVars = $sg->arVarAssignments;
#var_dump($mandatoryResult);exit;
        
        // If the mandatory result is empty... return it.
        $empty = true;
        foreach ($mandatoryResult as $mResult) {
            if (count($mResult) > 0) {
                $empty = false;
                break;
            }
        }
        
        if ($empty) {
            return array('data' => $mandatoryResult, 'vars' => $originalVars);
        }
        
        $replaceArray = array();
        foreach ($mandatoryResult as $r) {
            foreach ($r as $row) {
                foreach ($usedVars as $var) {
                    if (!isset($replaceArray[$var])) {
                        if (isset($mandatoryVars[$var]['sql_value']) && 
                            null !== $row[$mandatoryVars[$var]['sql_value']]) {
                             
                             if ($mandatoryVars[$var][1] !== 'o' || 
                                    $row[$mandatoryVars[$var]['sql_is']] !== 2) {

                                    $replaceArray[$var] = array();
                                    $replaceArray[$var][$row[$mandatoryVars[$var]['sql_value']]] = true;
                                }
                        }
                    } else {
                        if ($mandatoryVars[$var][1] !== 'o' || 
                            $row[$mandatoryVars[$var]['sql_is']] !== 2) {
                                
                            $replaceArray[$var][$row[$mandatoryVars[$var]['sql_value']]] = true; 
                        }
                    }
                }
            }
        }
        reset($mandatoryResult);

#var_dump($replaceArray);exit;     
        // Remove all old mandatory constraints from the query (already done with the first query).
        // Replace them with a new sameTerm constraint
        #require_once 'Erfurt/Sparql/Constraint.php';
        #$cArray = array();
        
        #$distinctKeys = array();
// TODO Function nesting fatal error on big result :(
        /*foreach ($replaceArray as $var => $values) {
            $distinctKeys[] = $var;
            $c = new Erfurt_Sparql_Constraint();
            
            $valueSameTermArray = array();
            foreach ($values as $key => $true) {
                $valueSameTermArray[] = 'sameTerm(' . $var . ', <' . $key . '>)';
            }
            
            $expr = '(' . implode(' || ', $valueSameTermArray) . ')';
            $c->addExpression($expr);
            $c->parse();
            $cArray[] = $c;          
        }*/
#var_dump($cArray);exit;      
        
        /*$ids = array();
        foreach ($optionals as $graphPattern) {
            $newCArray = array();
            foreach ($cArray as $c) {
                $add = false;
                $usedVars = $c->getUsedVars();
                foreach ($graphPattern->getVariables() as $v) {
                    if (in_array($v, $usedVars)) {
                        $add = true;
                        break;
                    }
                }
                
                if ($add) {
                    $newCArray[] = $c;
                }
            }
          
            #$graphPattern->setConstraints($newCArray);
            foreach ($oldMandatory as $gp) {
                if ($graphPattern->getOptional() === $gp->getId() && !empty($newCArray)) {
                    $gp->setTriplePatterns(array());
                    $gp->setConstraints($newCArray);
                }
                
                
            }
            
            $ids[$graphPattern->getOptional()] = true;
        }
     
        foreach ($oldMandatory as $key => $pattern) {
            if (!isset($ids[$pattern->getId()])) {
                $unsetIds[$pattern->getId()] = true;
                unset($oldMandatory[$key]);
            }
        }
        foreach ($oldMandatory as $pattern) {
            if (isset($unsetIds[$pattern->getUnion()])) {
                $pattern->setUnion(null);
            }
        }
        */
        
        
        
        #require_once 'Erfurt/Sparql/GraphPattern.php';
        #require_once 'Erfurt/Sparql/QueryTriple.php';
        #require_once 'Erfurt/Rdf/Resource.php';
        #$pattern = new Erfurt_Sparql_GraphPattern();
        #$pattern->setId(1000);
        #$pattern->setOptional(0);
        #$pattern->addTriplePattern(new Erfurt_Sparql_QueryTriple('?predicate', Erfurt_Rdf_Resource::initWithUri('dummy'), Erfurt_Rdf_Resource::initWithUri('dummy')));
        
    #    $optionals[] = $pattern;

        foreach ($oldMandatory as $gp) {
            $gp->setTriplePatterns(array());
            $gp->setConstraints(array());
        }


        // Set new result form to select (not distinct)
        #$newPatterns = $optionals;
        $newPatterns = array_merge($oldMandatory, $optionals);
        $usedVars = array();
        foreach ($newPatterns as $pattern) {
            $vars = $pattern->getVariables();
            foreach ($vars as $v) {
                $usedVars[$v] = true;
            }
        }
        $usedVarsObjects = array();
        foreach ($usedVars as $key => $true) {
            $usedVarsObjects[] = new Erfurt_Sparql_QueryResultVariable($key);
        }
        
        $query->setResultVars($usedVarsObjects);
        $query->setResultPart($newPatterns);
        $query->setResultForm('select');
#var_dump($query);exit;
        require_once 'Erfurt/Sparql/EngineDb/SqlGenerator/Adapter/Ef.php';
        $sg = new Erfurt_Sparql_EngineDb_SqlGenerator_Adapter_Ef($query, $this->_engine->getModelIdMapping());
            
        require_once 'Erfurt/Sparql/EngineDb/TypeSorter.php';
        $ts = new Erfurt_Sparql_EngineDb_TypeSorter($query, $this->_engine);

        $arSqls = $sg->createSql();

        $ts->setData($sg);
        $orderifiedSqls = $ts->getOrderifiedSqls($arSqls);
        $optionalVars = $sg->arVarAssignments;

#var_dump($optionalVars);
#var_dump($replaceArray);exit;

        $whereAddition = array();
        foreach ($optionalVars as $var => $varSpec) {
            foreach ($replaceArray as $key => $values) {
                if ($var === $key) {
                    $whereAddition[] = $varSpec[0] . '.' . $varSpec[1] . ' IN ("' 
                                     . implode('","', array_keys($values)) . '")';
                }
            }
        }


        foreach ($orderifiedSqls as &$sqlArray) {
            foreach ($sqlArray as &$sql) {
                if(!empty($whereAddition)) $sql['where'] .= ' AND ' . implode(' AND ', $whereAddition);
            }
        }
#var_dump($orderifiedSqls);exit;

        $optionalResult = $this->_queryMultiple($query, $orderifiedSqls);
        
#var_dump($optionalResult);exit;


#var_dump($originalVars, $optionalVars, $optionalResult);exit;
        
        $newOptResult = array();
        // Remove double entries
        $alreadyIn = array();
        foreach ($optionalResult as $r) {
            foreach ($r as $row) {
                $md5 = md5(serialize($row));
                
                if (!isset($alreadyIn[$md5])) {
                    $newOptResult[] = $row;
                    $alreadyIn[$md5] = true;
                }
            }
        }
        $optionalResult = array($newOptResult);
#var_dump($optionalVars);exit;
        
        
        $newResult = array();
    
#var_dump($mandatoryResult);exit;
        $mResult = current($mandatoryResult);
        while (true) {
            $rowSpec = array();
            $currentValue = null;
            $currentVarName = null;
            
            // Iterate through the first x vars, that are mandatory.
            // Break, if a non-mandatory var is reached.
            foreach ($originalVars as $varName => $varSpec) {
                // Vars is in original vars, but not selected, so ignore it.
                if (!isset($resultVars[$varName])) {
                    continue;
                }
                
                // Current var is in mandatory result... Add it.
                if (isset($mandatoryVars[$varName])) {
                    $mandatoryRow = current($mResult);
                    $currentValue = $mandatoryRow[$mandatoryVars[$varName]['sql_value']];
                    
                    $rowSpec[$varSpec['sql_value']] = $mandatoryRow[$mandatoryVars[$varName]['sql_value']]; 
                    
                    if (isset($varSpec['sql_is'])) {
                        $rowSpec[$varSpec['sql_is']] = $mandatoryRow[$mandatoryVars[$varName]['sql_is']];
                    }
                    
                    if (isset($varSpec['sql_ref'])) {
                        $rowSpec[$varSpec['sql_ref']] = $mandatoryRow[$mandatoryVars[$varName]['sql_ref']];
                    }
                    
                    if (isset($varSpec['sql_lang'])) {
                        $rowSpec[$varSpec['sql_lang']] = $mandatoryRow[$mandatoryVars[$varName]['sql_lang']];
                    }
                    
                    if (isset($varSpec['sql_type'])) {
                        $rowSpec[$varSpec['sql_type']] = $mandatoryRow[$mandatoryVars[$varName]['sql_type']];
                    }
                    
                    if (isset($varSpec['sql_dt_ref'])) {
                        $rowSpec[$varSpec['sql_dt_ref']] = $mandatoryRow[$mandatoryVars[$varName]['sql_dt_ref']];
                    }
                } else {
                    // Non-mandatory var reached... break;
                    $currentVarName = $varName;
                    break;
                }
            }

            $oldRowSpec = $rowSpec;
            $written = false;
            foreach ($optionalResult as $oResult) {
                foreach ($oResult as $optionalRow) {
                    $startReached = false;
                    $writeRow = false;
                    foreach ($originalVars as $varName => $varSpec) {
                        // Vars is in original vars, but not selected, so ignore it.
                        if (!isset($resultVars[$varName])) {
                            continue;
                        }

                        if (!$startReached && $varName !== $currentVarName) {
                            if (isset($optionalVars[$varName]) && 
                                $currentValue !== $optionalRow[$optionalVars[$varName]['sql_value']]) {
                                break;
                            }
                            
                            continue;
                        } else {
                            $startReached = true;
                            
                            
                        }
                        
                        
                        // If we reach this, we are save to write the current row
                        $written = true;
                        $writeRow = true;
                        
                        if (!isset($optionalVars[$varName])) {
                            $rowSpec[$varSpec['sql_value']] = null; 

                            if (isset($varSpec['sql_is'])) {
                                $rowSpec[$varSpec['sql_is']] = null;
                            }

                            if (isset($varSpec['sql_ref'])) {
                                $rowSpec[$varSpec['sql_ref']] = null;
                            }

                            if (isset($varSpec['sql_lang'])) {
                                $rowSpec[$varSpec['sql_lang']] = null;
                            }

                            if (isset($varSpec['sql_type'])) {
                                $rowSpec[$varSpec['sql_type']] = null;
                            }

                            if (isset($varSpec['sql_dt_ref'])) {
                                $rowSpec[$varSpec['sql_dt_ref']] = null;
                            }
                            
                            continue;
                        }
                        
                        $rowSpec[$varSpec['sql_value']] = $optionalRow[$optionalVars[$varName]['sql_value']]; 

                        if (isset($varSpec['sql_is'])) {
                            $rowSpec[$varSpec['sql_is']] = $optionalRow[$optionalVars[$varName]['sql_is']];
                        }

                        if (isset($varSpec['sql_ref'])) {
                            $rowSpec[$varSpec['sql_ref']] = $optionalRow[$optionalVars[$varName]['sql_ref']];
                        }

                        if (isset($varSpec['sql_lang'])) {
                            $rowSpec[$varSpec['sql_lang']] = $optionalRow[$optionalVars[$varName]['sql_lang']];
                        }

                        if (isset($varSpec['sql_type'])) {
                            $rowSpec[$varSpec['sql_type']] = $optionalRow[$optionalVars[$varName]['sql_type']];
                        }

                        if (isset($varSpec['sql_dt_ref'])) {
                            $rowSpec[$varSpec['sql_dt_ref']] = $optionalRow[$optionalVars[$varName]['sql_dt_ref']];
                        }
                    }
                    
                    // We have found optional data for the current row
                    if ($writeRow) {
                        $newResult[] = $rowSpec;
                        $rowSpec = $oldRowSpec;
                    }
                }
            }
            
            // If we have written nothing, we need to fill up the row with null values.
            if (!$written) {
                $startReached = false;
                foreach ($originalVars as $varName => $varSpec) {
                    // Vars is in original vars, but not selected, so ignore it.
                    if (!isset($resultVars[$varName])) {
                        continue;
                    }

                    if (!$startReached && $varName !== $currentVarName) {
                        continue;
                    } else {
                        $startReached = true;
                    }
                
                
                    $rowSpec[$varSpec['sql_value']] = null; 

                    if (isset($varSpec['sql_is'])) {
                        $rowSpec[$varSpec['sql_is']] = null;
                    }

                    if (isset($varSpec['sql_ref'])) {
                        $rowSpec[$varSpec['sql_ref']] = null;
                    }

                    if (isset($varSpec['sql_lang'])) {
                        $rowSpec[$varSpec['sql_lang']] = null;
                    }

                    if (isset($varSpec['sql_type'])) {
                        $rowSpec[$varSpec['sql_type']] = null;
                    }

                    if (isset($varSpec['sql_dt_ref'])) {
                        $rowSpec[$varSpec['sql_dt_ref']] = null;
                    }
                }
                
                $newResult[] = $rowSpec;
            }
            
            if (next($mResult) === false) {
                $mResult = next($mandatoryResult);

                if ($mResult === false) {
                    break;
                }
            }
        }

#var_dump($newResult);exit;

        $retVal = array($newResult);
        return array('data' => $retVal, 'vars' => $originalVars);
    }
    
    protected function _queryDb($query, $arSql, $nOffset, $nLimit)
    {
        require_once 'Erfurt/Sparql/EngineDb/SqlMerger.php';
        $strSql = Erfurt_Sparql_EngineDb_SqlMerger::getSelect($query, $arSql);
#echo $strSql;
        if ($strSql === '()') {
            return array();
        }
      
        if ($nLimit === null && $nOffset == 0) {
            $ret = $this->_engine->sqlQuery($strSql);
        } else if ($nLimit === null) {
            $ret = $this->_engine->sqlQuery($strSql . ' LIMIT ' . $nOffset . ', 18446744073709551615');
        } else {
            $ret = $this->_engine->sqlQuery($strSql . ' LIMIT ' . $nOffset . ', ' . $nLimit);
        }
#var_dump($ret->fetchAll());exit;
        return $ret;
    }

    /**
     * Executes multiple SQL queries and returns an array of results.
     *
     * @param array $arSqls Array of SQL queries.
     * @return array Array of query results.
     */
    protected function _queryMultiple($query, $arSqls)
    {
        $arSM = $query->getSolutionModifier();
        
        if ($arSM['limit'] === null && $arSM['offset'] === null) {
            $nOffset = 0;
            $nLimit  = null;
            $nSql    = 0;
        } else {
            require_once 'Erfurt/Sparql/EngineDb/Offsetter.php';
            $offsetter = new Erfurt_Sparql_EngineDb_Offsetter($this->_engine, $query);
            list($nSql, $nOffset) = $offsetter->determineOffset($arSqls);
            $nLimit    = $arSM['limit'];
        }
#var_dump($arSqls, $offsetter->determineOffset($arSqls));
        $nCount    = 0;
        $arResults = array();
        foreach ($arSqls as $nId => $arSql) {
            if ($nId < $nSql) { 
                continue; 
            }

            if ($nLimit != null) {
                $nCurrentLimit = $nLimit - $nCount;
            } else {
                $nCurrentLimit = null;
            }

            $dbResult = $this->_queryDb($query, $arSql, $nOffset, $nCurrentLimit);
#var_dump($dbResult);   
            $nCount     += count($dbResult);
            $arResults[] = $dbResult;
            $nOffset = 0;
            if ($nLimit !== null && $nCount >= $nLimit) {
                break;
            }
        }
        
        return $arResults;
    }
}

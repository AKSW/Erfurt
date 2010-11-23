<?php
/**
*   Simplifies ("flattens") Query objects that have graph
*   patterns which are subpatterns of other patterns.
*
*   Example:
*      ?g ?h ?i .
*      {
*        {?person <some://typ/e> 'asd'}
*        UNION
*        {?person3 <some://typ/es2> 'three'}
*      }
*    is represented internally as three graph patterns, the latter
*    two referencing the first to be their pattern (they are subpatternOf).
*    Now this can be flattened to this which is the same:
*      {?g ?h ?i . ?person <some://typ/e> 'asd'}
*      UNION
*      {?g ?h ?i .?person3 <some://typ/es2> 'three'}
*
*   This class does this.
*
*   @author Christian Weiske <cweiske@cweiske.de>
*   @license http://www.gnu.org/licenses/lgpl.html LGPL
*/
class Erfurt_Sparql_EngineDb_QuerySimplifier 
{
    /**
     *   Simplify the query by flattening out subqueries.
     *   Modifies the passed query object directly.
     */
    public function simplify(Erfurt_Sparql_Query $query) {
#return;
        $arPatterns = $query->getResultPart();
        self::dropEmpty($arPatterns);

        $arPlan = $this->createPlan($arPatterns);
        if (count($arPlan) == 0) {
            $query->setResultPart($arPatterns);
            return 0;
        }

        $this->executePlan($arPatterns, $arPlan);
        $query->setResultPart($arPatterns);
    }



    /**
     *   Creates a plan what to do.
     *
     *   @return array Array of arrays. Key is the parent pattern id,
     *               value is an array of subpatterns that belong to
     *               that parental pattern.
     */
    protected function createPlan(&$arPatterns)
    {
        $arNumbers = $this->getNumbers($arPatterns);

        if (count($arNumbers) === 0) {
            return array();
        }

        $arPlan    = array();

        foreach ($arNumbers as $nId => $nPatternCount) {
            $nParent = $arPatterns[$nId]->getSubpatternOf();   
            $arPlan[$nParent][$nId] = true;
        }
        
        return $arPlan;
    }



    /**
     *   Executes the plan
     *
     *   @param array $arPatterns  Array of GraphPatterns
     *   @param array $arPlan      Plan array as returned by createPlan()
     */
    protected function executePlan(&$arPatterns, &$arPlan)
    {
        $id = count($arPatterns)+1;
        foreach ($arPlan as $nParent => $arChildren) {
            $base           = $arPatterns[$nParent];
            #$grandParent    = $base->getSubpatternOf();
            $nNextId        = $nParent;
            $oldConstraints = $base->getConstraints();
            
            // collect all optionals for the current element
            $optionalIds = $this->_getOptionalIds($arPatterns, $nParent);

            foreach ($arChildren as $nChild => $null) {
                #$new = clone $base;
                #$new->addTriplePatterns($arPatterns[$nChild]->getTriplePatterns());
                #$new->addConstraints($arPatterns[$nChild]->getConstraints());
                
                $arPatterns[$nChild]->addTriplePatterns($base->getTriplePatterns());
                    
                // Catch all used vars from child pattern.
                $usedVars = array();
                foreach ($arPatterns[$nChild]->getTriplePatterns() as $tp) {
                    if (is_string($tp->getSubject())) {
                        $usedVars[] = $tp->getSubject();
                    }
                    if (is_string($tp->getPredicate())) {
                        $usedVars[] = $tp->getPredicate();
                    }
                    if (is_string($tp->getObject())) {
                        $usedVars[] = $tp->getObject();
                    }
                }
                foreach ($optionalIds as $oId) {
                    foreach ($arPatterns[$oId]->getTriplePatterns() as $tp) {
                        if (is_string($tp->getSubject())) {
                            $usedVars[] = $tp->getSubject();
                        }
                        if (is_string($tp->getPredicate())) {
                            $usedVars[] = $tp->getPredicate();
                        }
                        if (is_string($tp->getObject())) {
                            $usedVars[] = $tp->getObject();
                        }
                    }
                }
                $usedVars = array_unique($usedVars);

                $neededConstraints = array();
                foreach ($base->getConstraints() as $c) {
                    $needed = false;
                    $tempVars = $c->getUsedVars();
         
                    // Emmpty graph patterns need special attention... just reach trough the filters...
                    // they will be handled in the children patterns...
                    if (count($usedVars) === 0) {
                        $needed = true;
                    } else {
                        foreach ($tempVars as $var) {
                            if (in_array($var, $usedVars, true)) {
                                $needed = true;
                                break;
                            }
                        }
                    }
         
                    if ($needed === true) {
                        $neededConstraints[] = $c;
                    }
                    
                   
                }
                $arPatterns[$nChild]->addConstraints($neededConstraints);
                
                // Get the current optionals for the child and put the id at the end of optionalIds
                $removableOpts = array();
                foreach ($arPatterns as $nId3 => $opPattern) {
                    if ($opPattern->getOptional() === $arPatterns[$nChild]->patternId) {
                        $removableOpts[] = $opPattern->patternId;
                    }
                }
                $removableOpts = array_unique($removableOpts);
            
            
                // Create a new optional pattern for each optional pattern of the parent
                foreach ($optionalIds as $oId) {
                    $newOpt = clone $arPatterns[$oId];
                    $newOpt->setOptional($arPatterns[$nChild]->patternId);
                    
                    while (true) {
                        if (array_key_exists($id, $arPatterns)) {
                            $id++;
                        } else {
                            break;
                        }
                    }
                    
                    $newOpt->patternId = $id;
                    $arPatterns[$id] = $newOpt;
                }
                
                foreach ($removableOpts as $oId) {
                    $newOpt = clone $arPatterns[$oId];
                    $newOpt->setOptional($arPatterns[$nChild]->patternId);
                    
                    while (true) {
                        if (array_key_exists($id, $arPatterns)) {
                            $id++;
                        } else {
                            break;
                        }
                    }
                    
                    $newOpt->patternId = $id;
                    $arPatterns[$id] = $newOpt;
                    
                    unset($arPatterns[$oId]);
                } 
            }
            
            unset($arPatterns[$nParent]);
        } 
   
        // Reset all subpatternOf and optional attributes (remove not existing ones).
        foreach ($arPatterns as $nId => &$pattern) {
            $nParentId = $pattern->getSubpatternOf();
            $nOptionalId = $pattern->getOptional();
            
            if ($nParentId !== null && !isset($arPatterns[$nParentId])) {
                $pattern->setSubpatternOf(null);
            }
            if ($nOptionalId !== null && !isset($arPatterns[$nOptionalId])) {
                unset($arPatterns[$pattern->patternId]);
            }
        }
        
        // Connect all pattern (that are not optional patterns) with a union
        $lastId = null;
        foreach ($arPatterns as $nId => &$pattern) {
            if ($pattern->getOptional() === null) {
                if ($lastId !== null) {
                    $pattern->setUnion($lastId);
                    $lastId = $pattern->patternId;
                } else {
                    $lastId = $pattern->patternId;
                }
            }
        }
    }

    protected function _getOptionalIds(&$arPatterns, $nTestId, $recursive = true)
    {
        $result = array();
        foreach ($arPatterns as $nId => $pattern) {
            if ($pattern->getOptional() === $nTestId) {
                $result[] = $pattern->patternId;
            }
        }
        
        if ($recursive === true) {
            foreach ($result as $tempId) {
                $result = array_merge($result, $this->_getOptionalIds($arPatterns, $tempId, true));
            }
        }

        return $result;
    }

    /**
     *   Returns an array of id-value pairs determining
     *   which pattern IDs (array id) are deepest nested
     *   (higher value).
     *   Array is sorted in reverse order, highest values
     *   first.
     *
     *   @param array $arPatterns    Array with GraphPatterns
     *   @return array Array with key-value pairs
     */
    protected function getNumbers(&$arPatterns)
    {
        $arNumbers = array();
        foreach ($arPatterns as $nId => $pattern) {
            $nParent = $pattern->getSubpatternOf();
            
            if ($nParent !== null) {
                $arNumbers[$nId] = (isset($arNumbers[$nParent]) ? $arNumbers[$nParent] : 0)  + 1;
            } else {
                $arNumbers[$nId] = 0;
            }
        }

        //remove the not so interesting ones
        foreach ($arNumbers as $nId => $nNumber) {
            if ($nNumber === 0) {
                unset($arNumbers[$nId]);
            }
        }

        asort($arNumbers);
        return $arNumbers;
    }

    /**
     *   Removes all empty graph patterns from the array.
     *   Modifies it directly.
     */
    protected static function dropEmpty(&$arPatterns)
    {   
        $id = count($arPatterns)+1;
        $newOptionalMapping = array(); // $oldId => array($newId1, $newId2)
        foreach ($arPatterns as $nId => $pattern) {
            if ($pattern->isEmpty()) {   
                foreach ($arPatterns as $nId2 => &$pattern2) {
                    if ($pattern2->getSubpatternOf() === $pattern->patternId) {
                       $pattern2->setSubpatternOf($pattern->getSubpatternOf());
                       
                       if (!isset($newOptionalMapping[$pattern->patternId])) {
                           $newOptionalMapping[$pattern->patternId] = array();
                       }
                       $newOptionalMapping[$pattern->patternId][] = $pattern2->patternId;
                    } else if ($pattern2->getUnion() === $pattern->patternId) {
                        $pattern2->setUnion($pattern->getUnion());
                    } else if ($pattern2->getOptional() === $pattern2->patternId) {
                        if (null !== $pattern->getUnion()) {
                            $pattern->setOptional($pattern->getUnion());
                        } else if (null !== $pattern->getSubpatternOf()) {
                                $pattern->setOptional($pattern->getSubpatternOf());
                        }
                    }
                }
                
                unset($arPatterns[$nId]);
            }
        }
        
        foreach ($arPatterns as $nId => &$pattern) {
            $nParent = $pattern->getSubpatternOf();
            if (null !== $nParent && !isset($arPatterns[$nParent])) {
                $pattern->setSubpatternOf(null);
            }
            
            $nUnion = $pattern->getUnion();
            if (null !== $nUnion && !isset($arPatterns[$nUnion])) {
                $pattern->setUnion(null);
            }
            
            $nOptional = $pattern->getOptional();
            if (null !== $nOptional && !isset($arPatterns[$nOptional])) {
                if (isset($newOptionalMapping[$nOptional])) {
                    $pattern->setOptional($newOptionalMapping[$nOptional][0]);
                    
                    if (count($newOptionalMapping[$nOptional]) > 1) {
                        
                        $countNOM = count($newOptionalMapping[$nOptional]);
                        
                        for ($i = 1; $i < $countNOM; ++$i) {
                            $newPattern = clone $pattern;
                            
                            while (true) {
                                if (array_key_exists($id, $arPatterns)) {
                                    ++$id;
                                } else {
                                    break;
                                }
                            }
                            
                            $newPattern->setId($id);
                            $newPattern->setOptional($newOptionalMapping[$nOptional][$i]);
                            $arPatterns[] = $newPattern;
                        }
                    }
                } else {
                    $pattern->setOptional(null);
                }
            }
        }
    }
}

<?php
require_once 'Erfurt/Sparql/EngineDb/SqlGenerator.php';

/**
*   Creates sql statements from a Query object
*
*   @author Christian Weiske <cweiske@cweiske.de>
*   @license http://www.gnu.org/licenses/lgpl.html LGPL
*
*   @subpackage sparql
*/
class Erfurt_Sparql_EngineDb_SqlGenerator_Adapter_Ef extends Erfurt_Sparql_EngineDb_SqlGenerator
{
    public $arTableColumnNames = array(
        's' => array(
            'value' => 's',
            'is'    => 'st'
        ),
        'p' => array(
            'value' => 'p'
        ),
        'o' => array(
            'value' => 'o',
            'is'    => 'ot'
        ),
        'datatype' => array(
            'value' => 'od',
            'empty' => '=""',
            'not_empty' => '!=""'
        ),
        'language' => array(
            'value' => 'ol',
            'empty' => '=""',
            'not_empty' => '!=""'
        )
    );
    
    public $arTypeValues = array(
        'r' => '0',
        'b' => '1',
        'l' => '2'
    );
    
    public $strColEmpty = 'IS NULL';
    public $strColNotEmpty = 'IS NOT NULL';
       
    public $query = null;

    /**
    *   Determines which variables can be found
    *   in which SQL result column.
    *   @example
    *   array(
    *       '?person' => array('t1', 's'),
    *       '?p'      => array('t1', 'p'),
    *       '?mbox'   => array('t2', 'o')
    *   )
    *   Would express that variable ?person is the subject
    *   in result table t1, and ?mbox is the object in
    *   table t2.
    *
    *   @see $arCreationMethods
    *
    *   @internal The array is created in createSql()
    *   and used in convertFromDbResult().
    *
    *   @var array
    */
    public $arVarAssignments = array();

    /**
    *   Array of variable name => table.col assignments
    *   for all variables used in the query not only
    *   the ones that shall be returned.
    *
    *   @example
    *   array(
    *       '?person'   => 't0.subject'
    *   )
    *
    *   @var array
    */
    public $arUsedVarAssignments = array();

    /**
    *   Array of arrays that contain all variable names
    *   which are to be found in the result of
    *   an sql statement in a union.
    *
    *   @example
    *   array(
    *       0 => array(
    *           '?person' => 's',
    *           '?p' => 'o'
    *       ),
    *       1 => array(
    *           '?person' => 's',
    *           '?mbox' => 'o'
    *       )
    *   )
    *
    *   @var array
    */
    public $arUnionVarAssignments = array();

    /**
    *   Which variables have been used as which type?
    *   key is variable name, value is an array of
    *   max. three keys (s, p, o)
    *
    *   @example
    *   array(
    *       '?person' => array(
    *           's' => true
    *       ),
    *       '?mbox' => array(
    *           'o' => true
    *       )
    *   )
    *
    *   @var array
    */
    protected $arUsedVarTypes = array();

    /**
    *   Array with placeholders of prepared statements variables.
    *   key is the variable name (without "??"), value is the
    *   placeholder.
    *   @var array
    */
    protected $arPlaceholders = array();

    /**
    *   Current UNION part number
    *   @var int
    */
    protected $nUnionCount = 0;

    protected $nSqlVariableNameCount = 0;

    /**
    *   Name of the statements table
    */
    protected $tblStatements = 'ef_stmt';



    public function __construct(Erfurt_Sparql_Query $query, array $arModelIdMapping) {
    
        $this->query                = $query;
        $this->arModelIds           = array();
        
        foreach ($query->getFromPart() as $from) {
            if (isset($arModelIdMapping[$from])) {
                $this->arModelIds[] = $arModelIdMapping[$from]['modelId'];
            } else {
                $this->arModelIds[] = -1;
            }
        }    
        
        foreach ($query->getFromNamedPart() as $from) {
            if (isset($arModelIdMapping[$from])) {
                $this->arModelIds[] = $arModelIdMapping[$from]['modelId'];
            } else {
                $this->arModelIds[] = -1;
                
            }
        }
    }

    /**
     *   Creates an SQL query string from the given Sparql query object.
     *
     *   @internal uses $query variable
     *
     *   @return array       Array of arrays of SQL query string parts: select, from and where
     *
     *   @throws Erfurt_Sparql_EngineDb_SqlGeneratorException   If there is no variable in the result set.
     */
    public function createSql()
    {
        $arSelect   = array();
        $arFrom     = array();
        $arWhere    = array();

        $strResultForm = $this->query->getResultForm();
        require_once 'Erfurt/Sparql/EngineDb/FilterGenerator.php';
        $filterGen = new Erfurt_Sparql_EngineDb_FilterGenerator($this);
        switch ($strResultForm) {
            case 'construct':
                $arResultVars = $this->query->getConstructPatternVariables();
                break;
            default:
                $arResultVars = $this->query->getResultVars();
                break;
        }

        $this->nTableId                 = 0;
        $this->nGraphPatternCount       = 0;
        $this->nUnionCount              = 0;
        $this->nUnionTriplePatternCount = 0;
        $this->arUnionVarAssignments[0] = array();

        foreach ($this->query->getResultPart() as $graphPattern) {
            
            #if ($graphPattern->isEmpty()) {
            #    continue;
            #}
            
            if ($graphPattern->getUnion() !== null) {
                ++$this->nUnionCount;
                $this->nTableId                 = 0;
                $this->nUnionTriplePatternCount = 0;
                $this->nGraphPatternCount = 0;
                $this->arUnionVarAssignments[$this->nUnionCount] = array();
                
                // 2009-04-23: Is it OK to reset this, when we start the next union?
                $this->arUsedVarAssignments = array();
            }
            
            if ($graphPattern->getOptional() !== null) {
                continue;
            }
            
            $this->nTriplePatternCount = 0;
            $arTriplePattern = $graphPattern->getTriplePatterns();
   
            if ($arTriplePattern != null) {
                foreach ($arTriplePattern as $triplePattern) {
                    list (
                        $arSelect[$this->nUnionCount][],
                        $arFrom  [$this->nUnionCount][],
                        $arWhere [$this->nUnionCount][]
                    ) =
                        $this->getTripleSql(
                            $triplePattern,
                            $graphPattern,
                            $arResultVars
                        );
                        
                    ++$this->nTableId;
                    ++$this->nTriplePatternCount;
                    ++$this->nUnionTriplePatternCount;
                }
                ++$this->nGraphPatternCount;
            }
             
            foreach ($this->query->getResultPart() as $optionalPattern) {
                if ($optionalPattern->getOptional() === $graphPattern->patternId) {
                    $this->nTriplePatternCount = 0;
                    $arTriplePattern = $optionalPattern->getTriplePatterns();
                    if ($arTriplePattern != null) {
                        foreach ($arTriplePattern as $triplePattern) {
                            list (
                                $arSelect[$this->nUnionCount][],
                                $arFrom  [$this->nUnionCount][],
                                $arWhere [$this->nUnionCount][]
                            ) =
                                $this->getTripleSql(
                                    $triplePattern,
                                    $optionalPattern,
                                    $arResultVars
                                );

                            ++$this->nTableId;
                            ++$this->nTriplePatternCount;
                            ++$this->nUnionTriplePatternCount;
                        }
                    }
                    ++$this->nGraphPatternCount;
                }
            }
        }


        //constraints extra. needed, since OPTIONAL parts are put after
        // the current pattern while the constraint already refers to variables
        // defined in there
        $this->nGraphPatternCount       = 0;
        $this->nUnionCount              = 0;
        foreach ($this->query->getResultPart() as $graphPattern) {
            if ($graphPattern->getUnion() !== null) {
                ++$this->nUnionCount;
            }
            $arConstraints = $graphPattern->getConstraints();

            if ($arConstraints != null) {
                if(isset($arWhere[$this->nUnionCount])){
                    foreach ($arConstraints as $constraint) {
                        $arWhere[$this->nUnionCount][count($arWhere[$this->nUnionCount]) - 1]
                         .= $filterGen->createFilterSql(
                            $constraint->getTree(),
                            $graphPattern->getOptional() !== null,
                            $this->nUnionCount
                        );
                    }
                }
            }
            ++$this->nGraphPatternCount;
        }
        
        $arSelect    = $this->createEqualSelects($arSelect);
        $arStrSelect = array();

        switch ($strResultForm) {
            case 'construct':
            case 'describe':
                $strSelectType = 'SELECT';
            case 'select':
            case 'select distinct':
                if (!isset($strSelectType)) {
                    $strSelectType = $strResultForm;
                }
                foreach ($arSelect as $nUnionCount => $arSelectPart) {
                    $arSelectPart = $this->removeNull($arSelectPart);
                    if (count($arSelectPart) == 0
                    || (count($arSelectPart) == 1 && $arSelectPart[0] == '')) {
                        //test "test-1-07" suggests we return no rows in this case
                        //throw new Erfurt_Sparql_EngineDb_SqlGeneratorException('No variable that could be returned.');
                    } else {
                        $arStrSelect[$nUnionCount] = strtoupper($strSelectType) . ' ' . implode(','   , $arSelectPart);
                    }
                }
                break;

            case 'ask':
            case 'count':
                $arStrSelect = array('SELECT COUNT(*) as count');
                break;
            case 'count-distinct':
                $arStrSelect = array('SELECT COUNT(DISTINCT(t0.s)) as count');
                break;
            default:
                require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                    'Unsupported query type "' . $strResultForm . '"');
                break;
        }

        $arSqls = array();
        foreach ($arStrSelect as $nUnionCount => $arSelectPart) {
            $arSqls[] = array(
                'select'    => $arSelectPart,
                'from'      => ' FROM '  . implode(' '    , $this->removeNull($arFrom[$nUnionCount])),
                'where'     => ' WHERE ' . $this->fixWhere(
                            implode(' '  , $this->removeNull($arWhere[$nUnionCount]))
                )
            );
        }
        
        return $arSqls;
    }//function createSql()



    /**
    *   Creates some SQL statements from the given triple pattern
    *   array.
    *
    *   @param QueryTriple  $triple                 Array containing subject, predicate and object
    *   @param GraphPattern $graphPattern           Graph pattern object
    *
    *   @return array   Array consisting of on array and two string values:
    *                   SELECT, FROM and WHERE part
    */
    function getTripleSql(Erfurt_Sparql_QueryTriple $triple, Erfurt_Sparql_GraphPattern $graphPattern, $arResultVars)
    {
        $arSelect  = array();
        $strFrom    = null;
        $strWhere   = null;
        $strWhereEquality        = '';
        $bWhereEqualitySubject   = false;
        $bWhereEqualityPredicate = false;
        $bWhereEqualityObject    = false;

        $subject    = $triple->getSubject();
        $predicate  = $triple->getPredicate();
        $object     = $triple->getObject();

        $arRefVars      = array();
        $strTablePrefix = 't' . $this->nTableId;

        /**
        *   SELECT part
        *   We do select only the columns we need for variables
        */
     
        require_once 'Erfurt/Sparql/Variable.php';

        if (Erfurt_Sparql_Variable::isVariable($subject)) {
            if (isset($this->arUnionVarAssignments[$this->nUnionCount][$subject])) {
                //already selected -> add equality check
                $bWhereEqualitySubject = true;
                $this->arUsedVarTypes[$subject]['s'] = true;
            } else {
                #if (isset($this->arVarAssignments[$subject][0])) {
                #    $strTablePrefix = $this->arVarAssignments[$subject][0];
                #}
                if (!isset($this->arVarAssignments[$subject])) {
                    $this->arVarAssignments[$subject] = array($strTablePrefix, 's');
                }
                
                #$this->arVarAssignments[$subject] = array($strTablePrefix, 's');
                $this->arVarAssignments[$subject][1] = 's';
                $this->arUnionVarAssignments[$this->nUnionCount][$subject] = array($strTablePrefix, 's');
                $this->arUsedVarTypes[$subject]['s'] = true;

                if ($this->isResultVar($subject, $arResultVars)) {
                    //new variable that needs to be selected
                    $arSelect[$subject] = $this->createVariableSelectArray(
                        's', $subject, $strTablePrefix
                    );

                    if (isset($this->arUsedVarAssignments[$subject])) {
                        $arRefVars[$subject] = $strTablePrefix . '.s';
                    } else {
                        $this->arUsedVarAssignments[$subject] = $strTablePrefix . '.s';
                    }
                }
            }
        }
         
        if (Erfurt_Sparql_Variable::isVariable($predicate)) {
            if (isset($this->arUnionVarAssignments[$this->nUnionCount][$predicate])) {
                //already selected -> add equality check
                $bWhereEqualityPredicate = true;
                $this->arUsedVarTypes[$predicate]['p'] = true;
            } else {
                #if (isset($this->arVarAssignments[$predicate][0])) {
                #    $strTablePrefix = $this->arVarAssignments[$predicate][0];
                #}
                if (!isset($this->arVarAssignments[$predicate])) {
                    $this->arVarAssignments[$predicate] = array($strTablePrefix, 'p');
                }
                
                #$this->arVarAssignments[$predicate] = array($strTablePrefix, 'p');
                $this->arVarAssignments[$predicate][1] = 'p';
                $this->arUnionVarAssignments[$this->nUnionCount][$predicate] = array($strTablePrefix, 'p');
                $this->arUsedVarTypes[$predicate]['p'] = true;
                if ($this->isResultVar($predicate, $arResultVars)) {
                    $arSelect[$predicate] = $this->createVariableSelectArray(
                        'p', $predicate, $strTablePrefix
                    );
                    if (isset($this->arUsedVarAssignments[$predicate])) {
                        $arRefVars[$predicate] = $strTablePrefix . '.p';
                    } else {
                        $this->arUsedVarAssignments[$predicate] = $strTablePrefix . '.p';
                    }
                }
            }
        }
       
        if (Erfurt_Sparql_Variable::isVariable($object)) {
            if (isset($this->arUnionVarAssignments[$this->nUnionCount][$object])) {
                //already selected -> add equality check
                $bWhereEqualityObject = true;
                $this->arUsedVarTypes[$object]['o'] = true;
            } else {
                #if (isset($this->arVarAssignments[$object][0])) {
                #    $strTablePrefix = $this->arVarAssignments[$object][0];
                #}
                if (!isset($this->arVarAssignments[$object])) {
                    $this->arVarAssignments[$object] = array($strTablePrefix, 'o');
                }
                
                $this->arVarAssignments[$object][1] = 'o';
                $this->arUnionVarAssignments[$this->nUnionCount][$object] = array($strTablePrefix, 'o');
                $this->arUsedVarTypes[$object]['o'] = true;
                if ($this->isResultVar($object, $arResultVars)) {
                    $arSelect[$object] = $this->createVariableSelectArray(
                        'o', $object, $strTablePrefix
                    );
                    if (isset($this->arUsedVarAssignments[$object])) {
                        $arRefVars[$object] = $strTablePrefix . '.o';
                    } else {
                        $this->arUsedVarAssignments[$object] = $strTablePrefix . '.o';
                    }
                }
                if (isset($this->query->varLanguages[$object])
                 && $this->query->varLanguages[$object] !== null
                ) {
                    $strWhereEquality .=
                        ' AND ' . $strTablePrefix . '.ol="'
                        . addslashes($this->query->varLanguages[$object]) . '"';
                }
                if (isset($this->query->varDatatypes[$object])
                 && $this->query->varDatatypes[$object] !== null
                ) {
                    $strWhereEquality .=
                        ' AND ' . $strTablePrefix . '.ol="'
                        . addslashes($this->query->varDatatypes[$object]) . '"';
                }
            }
        }
   
        /**
        * WhereEquality - needs to be done now because strTablePrefix may change
        */
        if ($bWhereEqualitySubject) {
            $strWhereEquality .= ' AND ' . $this->getSqlEqualityCondition(
                            array($strTablePrefix, 's'),
                            $this->arVarAssignments[$subject]
                        );
        }
        if ($bWhereEqualityPredicate) {
            $strWhereEquality .= ' AND ' . $this->getSqlEqualityCondition(
                            array($strTablePrefix, 'p'),
                            $this->arVarAssignments[$predicate]
                        );
        }
        if ($bWhereEqualityObject) {
            $strWhereEquality .= ' AND ' . $this->getSqlEqualityCondition(
                            array($strTablePrefix, 'o'),
                            $this->arVarAssignments[$object]
                        );
        }


        /**
        *   FROM part
        */
        //receive tableName from QueryCache ; if QueryCache dont have some special views
        //the original tableName will be chosen
        $tableName = $this->tblStatements;
        if ($viewName =  Erfurt_App::getInstance()->getQueryCache()->getMaterializedViewName($subject, $predicate, $object)) {
            $tableName = $viewName;
        }

        if ($this->nUnionTriplePatternCount == 0) {
            //first FROM
            $strFrom    = $tableName . ' as ' . $strTablePrefix;
        } else {
            //normal join
            if (count($this->arModelIds) == 1) {
                $strFrom    = 'LEFT JOIN ' . $tableName . ' as ' . $strTablePrefix
                            . ' ON t0.g=' . $strTablePrefix . '.g';
            } else if (count($this->arModelIds) > 1) {
                $arIDs     = array();
                foreach ($this->arModelIds as $nId) {
                    $arIDs[] = $strTablePrefix . '.g=' . intval($nId);
                }
                $strFrom  = 'LEFT JOIN ' . $tableName . ' as ' . $strTablePrefix
                          . ' ON (' . implode(' OR ', $arIDs) . ')';
            } else {
                $strFrom    = 'LEFT JOIN ' . $tableName . ' as ' . $strTablePrefix
                            . ' ON t0.g=' . $strTablePrefix . '.g';
            }
            
            if ($graphPattern->getOptional() !== null) {
                $strFrom .=  $this->getSqlCondition($subject  , $strTablePrefix, 's')
                           . $this->getSqlCondition($predicate, $strTablePrefix, 'p')
                           . $this->getSqlCondition($object   , $strTablePrefix, 'o')
                           . $strWhereEquality;
            }
        }



        /**
        *   WHERE part
        */
        if ($this->nUnionTriplePatternCount == 0) {
            if (count($this->arModelIds) == 1) {
                $strWhere  = $strTablePrefix . '.g=' . intval(reset($this->arModelIds));
            } else if (count($this->arModelIds) > 1) {
                $arIDs     = array();
                foreach ($this->arModelIds as $nId) {
                    $arIDs[] = $strTablePrefix . '.g=' . intval($nId);
                }
                $strWhere  = '(' . implode(' OR ', $arIDs) . ')';
            } else {
                //so that we can append an AND
                $strWhere = '1';
            }
        }
        if ($graphPattern->getOptional() === null || $this->nGraphPatternCount == 0) {
            $strWhere .=  $this->getSqlCondition($subject  , $strTablePrefix, 's')
                        . $this->getSqlCondition($predicate, $strTablePrefix, 'p')
                        . $this->getSqlCondition($object   , $strTablePrefix, 'o')
                        . $strWhereEquality;
        }

        return array($arSelect, $strFrom, $strWhere);
    }//function getTripleSql(QueryTriple $triple)




    protected function createVariableSelectArray($chType, $varname, $strTablePrefix)
    {
        $var = $this->query->getResultVar($varname);
        if ($var !== false) {
            if ((string)$var != $varname) {
                //copy over var assignments
                $this->arVarAssignments[(string)$var] = $this->arVarAssignments[$varname];
            }

            //works on non-* only
            $func = $var->getFunc();
            if ($func != null) {
                if ($func == 'datatype') {
                    if ($chType != 'o') {
                        require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                        throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                            'datatype() works on objects only'
                        );
                    }
                    return array(
                        $strTablePrefix . '.od as ' . $this->getSqlVariableNameValue($var),
                        $strTablePrefix . '.od_r as ' . $this->getSqlVariableNameRef($var),
                        '0 as ' . $this->getSqlVariableNameIs($var),
                        '"" as ' . $this->getSqlVariableNameLanguage($var),
                        '"" as ' . $this->getSqlVariableNameDatatype($var),
                    );
                } else if ($func == 'lang') {
                    if ($chType != 'o') {
                        require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                        throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                            'lang() works on objects only'
                        );
                    }
                    return array(
                        $strTablePrefix . '.ol as ' . $this->getSqlVariableNameValue($var),
                        '2 as ' . $this->getSqlVariableNameIs($var),
                        '"" as ' . $this->getSqlVariableNameLanguage($var),
                        '"" as ' . $this->getSqlVariableNameDatatype($var),
                    );
                } else {
                    require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                    throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                        'Unsupported function for select "' . $func . '"'
                    );
                }
            }
        }

        switch ($chType) {
            case 's':
                return array(
                    $strTablePrefix . '.s as ' . $this->getSqlVariableNameValue($varname),
                    $strTablePrefix . '.st as ' . $this->getSqlVariableNameIs($varname),
                    $strTablePrefix . '.s_r as ' . $this->getSqlVariableNameRef($varname)
                );
            case 'p':
                return array(
                    $strTablePrefix . '.p as ' . $this->getSqlVariableNameValue($varname),
                    'NULL as ' . $this->getSqlVariableNameIs($varname),
                    $strTablePrefix . '.p_r as ' . $this->getSqlVariableNameRef($varname)
                );
            case 'o':
                return array(
                    $strTablePrefix . '.o as ' . $this->getSqlVariableNameValue($varname),
                    $strTablePrefix . '.ot as ' . $this->getSqlVariableNameIs($varname),
                    $strTablePrefix . '.o_r as ' . $this->getSqlVariableNameRef($varname),
                    $strTablePrefix . '.ol as ' . $this->getSqlVariableNameLanguage($varname),
                    $strTablePrefix . '.od as ' . $this->getSqlVariableNameDatatype($varname),
                    $strTablePrefix . '.od_r as ' . $this->getSqlVariableNameDatatypeRef($varname)
                );
            default:
                require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                    'Unknown sentence type "' . $chType . "', one of (s,p,o) expected"
                );
        }
    }//protected function createVariableSelectArray($chType, $value, $strTablePrefix)



    /**
    *   Creates SELECT statements that have the same number of columns.
    *   Needed for UNIONs.
    *
    *   @param array $arSelect  Array of arrays.
    *       array(
    *           //for each union part one
    *           0 => array(
    *               //foreach triple pattern
    *               0 => array(
    *                   '?person'   => array(
    *                       't0.subject as "t0.subject"'
    *                   )
    *               )
    *           )
    *       )
    *   @return array Array of SELECT strings
    */
    protected function createEqualSelects($arSelect)
    {
        $arNewSelect = array();
        if (count($arSelect) == 1) {
            if ($arSelect[0] == array(array())) {
                //ASK and COUNT
                return array(array(''));
            }

            foreach ($arSelect[0] as $arTripleVars) {
                $ar = array();
                $arHasItems = false;
                
                foreach ($arTripleVars as $arVarParts) {
                    $ar[] = implode(',', $arVarParts);
                    $arHasItems = true;
                }
                // if (count($ar) > 0) {
                if ( true === $arHasItems ) {
                    $arNewSelect[0][] = implode(',', $ar);
                }
            }
            return $arNewSelect;
        }

        $arVars = array();
         foreach ($arSelect as $arUnionVars) {
            foreach ($arUnionVars as $arTripleVars) {
                $arVars = array_merge($arVars, array_keys($arTripleVars));
            }
        }
        $arVars = array_unique($arVars);

        foreach ($arSelect as $nUnionCount => $arUnionVars) {

            $arSelectVars = array();
            foreach ($arUnionVars as $arTripleVars) {
                foreach ($arTripleVars as $strVar => $arVarParts) {
                    $arSelectVars[$strVar] = $arVarParts;
                }
            }

            $ars = array();
            foreach ($arVars as $strVar) {
                if (isset($arSelectVars[$strVar])) {
                    $ar     = $arSelectVars[$strVar];
                    $nCount = count($arSelectVars[$strVar]);
                } else {
                    $ar     = array();
                    $nCount = 0;
                }

                if ($nCount == 0) {
                    //nothing of this variable in this union part
                    $ar[] = 'NULL as '
                        . $this->arVarAssignments[$strVar]['sql_value'];
                }
                if ((
                    isset($this->arUsedVarTypes[$strVar]['o'])
                    || isset($this->arUsedVarTypes[$strVar]['s'])
                    ) && $nCount < 2
                ) {
                    if (isset($this->arVarAssignments[$strVar]['sql_is'])) {
                        //it's a subject or object, but we don't want the type
                        $ar[] = 'NULL as '
                            . $this->arVarAssignments[$strVar]['sql_is'];
                    }
                    
                    $ar[] = 'NULL as '
                        . $this->arVarAssignments[$strVar]['sql_ref'];
                    
                }
                
                if (isset($this->arUsedVarTypes[$strVar]['o']) && $nCount < 4) {
                    //it's a subject or object, but we don't want the type
                    if (isset($this->arVarAssignments[$strVar]['sql_lang'])) {
                        $strColLanguage = $this->arVarAssignments[$strVar]['sql_lang'];
                    } else {
                        $strColLanguage = 'dL';
                    }
                    if (isset($this->arVarAssignments[$strVar]['sql_type'])) {
                        $strColDatatype = $this->arVarAssignments[$strVar]['sql_type'];
                        $strColDatatypeRef = $this->arVarAssignments[$strVar]['sql_dt_ref'];
                    } else {
                        $strColDatatype = 'dD';
                        $strColDatatypeRef = 'dDR';
                    }
                    $ar[] = '"" as '
                        . $strColLanguage;
                    $ar[] = '"" as '
                        . $strColDatatype;
                    $ar[] = 'NULL as '
                        . $strColDatatypeRef;
                }
                
                $ars[] = implode(',', $ar);
            }
            $arNewSelect[$nUnionCount] = $ars;
        }

        return $arNewSelect;
    }//protected function createEqualSelects($arSelect)

    private function _qstr($str) {
        
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        } 
            
        $str = str_replace("'", "\\'", $str);
        
        return "'" . $str . "'";
    }

    /**
    *   Creates an SQL statement that checks for the value
    *   of some subject/predicate/object
    *
    *   @param mixed    $bject          subject|predicate|object
    *   @param string   $strTablePrefix Table prefix (e.g. "t0")
    *   @param string   $strType        Type of $bject ('subject'|'predicate'|'object')
    *   @return string  Part of the SQL query (prefixed with AND)
    */
    function getSqlCondition($bject, $strTablePrefix, $strType)
    {
        require_once 'Erfurt/Sparql/Variable.php';
        if (is_string($bject)) {
            if (Erfurt_Sparql_Variable::isVariable($bject)) {
                //variable?
                if (self::isPreparedVariable($bject)) {
                    //no, not really
                    $value = $this->getPreparedVariablePlaceholder($bject);
                } else {
                    //yes
                    return null;
                }
            } else {
                $value = $this->_qstr($bject);
            }
            //literal
            return ' AND ' . $strTablePrefix . '.' . $strType . '=' . $value;
        }

        if ($bject instanceof Erfurt_Rdf_Resource && $bject->isBlankNode()) {
            //Blank node
            require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
            throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                'FIXME: Querying for blank nodes not supported'
            );

        } else if ($bject instanceof Erfurt_Rdf_Resource) {
            //Resource
            $r = ' AND ' . $strTablePrefix . '.' . $strType . '='
                . $this->_qstr($bject->getUri());
            if ($strType !== 'p') {
                $r .= ' AND ' . $strTablePrefix . '.' . $strType . 't=0';
            } 
            
            return $r;

        } else if ($bject instanceof Erfurt_Rdf_Literal) {
            //Literal
            //I'm doubling Filter code here, but what the hell
            $strColDatatype = $strTablePrefix . '.od';
            if ($bject->getDatatype() == 'http://www.w3.org/2001/XMLSchema#integer'
             || $bject->getdatatype() == 'http://www.w3.org/2001/XMLSchema#double'
            ) {
                $strVariable = 'CAST(' . $strTablePrefix . '.' . $strType . ' AS DECIMAL(15,10))';
                $strValue    = $bject->getLabel();
            } else {
                $strVariable = $strTablePrefix . '.' . $strType;
                $strValue    = $this->_qstr($bject->getLabel());
            }
            $r = ' AND ' . $strVariable . '=' . $strValue;
            if ($strType !== 'p') {
                $r .= ' AND ' . $strTablePrefix . '.' . $strType . 't=2';
            }

            if ($strType == 'o') {
                if ($bject->getDatatype() == '' || $bject->getDatatype() == 'http://www.w3.org/2001/XMLSchema#string') {
                    //string
                    $r .= ' AND ('
                        . $strColDatatype . '=""'
                        . ' OR ' . $strColDatatype . '="http://www.w3.org/2001/XMLSchema#string"'
                        . ')';
                } else {
                    $r .= ' AND ' . $strColDatatype . '="'
                        . $bject->getDatatype()
                        . '"';
                }
            }

            if ($bject->getLanguage() !== false) {
                $strColLanguage = $strTablePrefix . '.ol';
                $r .= ' AND ' . $strColLanguage . '='
                   . $this->_qstr($bject->getLanguage());
            } else {
                $strColLanguage = $strTablePrefix . '.ol';
                $r .= ' AND ' . $strColLanguage . '=""';
            }
            return $r;

        } else {
            require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
            throw new Erfurt_Sparql_EngineDb_SqlGeneratorException(
                'Unsupported sentence part: ' . get_class($bject)
            );
        }
    }//function getSqlCondition($bject, $strTablePrefix, $strType)



    /**
    *   Checks if the sentence part (subject, predicate or object) in
    *   $arNew has the same content as $arOld.
    *   Required for queries like ":x ?a ?a" where predicate and object
    *   need to have the same value
    *
    *   @param array    $arNew  array($strTablePrefix, $strType = s|p|o)
    *   @param array    $arOld  array($strTablePrefix, $strType = s|p|o)
    *   @return string
    */
    protected function getSqlEqualityCondition($arNew, $arOld)
    {
        $chTypeNew         = $arNew[1]; $chTypeOld         = $arOld[1];
        $strTablePrefixNew = $arNew[0]; $strTablePrefixOld = $arOld[0];

        if ($chTypeNew == 'p' || $chTypeOld == 'p') {
            //just check value
            //FIXME: it might be I need to check for resource type in object and subject
            return
                  $strTablePrefixNew . '.' . $this->arTableColumnNames[$chTypeNew]['value']
                . '='
                . $strTablePrefixOld . '.' . $this->arTableColumnNames[$chTypeOld]['value']
                ;
        } else if ($chTypeNew == 's' || $chTypeOld == 's') {
            //check value and type
            return
                  $strTablePrefixNew . '.' . $this->arTableColumnNames[$chTypeNew]['value']
                . '='
                . $strTablePrefixOld . '.' . $this->arTableColumnNames[$chTypeOld]['value']
                . ' AND '
                . $strTablePrefixNew . '.' . $this->arTableColumnNames[$chTypeNew]['is']
                . '='
                . $strTablePrefixOld . '.' . $this->arTableColumnNames[$chTypeOld]['is']
                ;
        } else {
            //two objects -> check everything
            return
                  $strTablePrefixNew . '.o=' . $strTablePrefixOld . '.o'
                . ' AND '
                . $strTablePrefixNew . '.ot='  . $strTablePrefixOld . '.ot'
                . ' AND '
                . $strTablePrefixNew . '.ol=' . $strTablePrefixOld . '.ol'
                . ' AND '
                . $strTablePrefixNew . '.od=' . $strTablePrefixOld . '.od';
        }
    }//protected static function getSqlEqualityCondition($arNew, $arOld)



    /**
    *   Checks if the given variable name is part of the result
    *   variables list.
    *   Needed since $arResultVars may contain "*" that captures all variables.
    *
    *   @param string   $strVar         Variable name (e.g. "?p")
    *   @param array    $arResultVars   Array with result variables
    *   @return boolean     true if it is a result variable
    */
    protected function isResultVar($strVar, &$arResultVars)
    {
        foreach ($arResultVars as $var) {
            if ($var == '*') {
                return true;
            } else if ((is_string($var) && $var == $strVar)
                || (is_object($var) && $var->getVariable() == $strVar)) {
                return true;
            }
        }
        return false;
    }//protected static function isResultVar($strVar, &$arResultVars)



    /**
    *   Checks if the given variable is a replacement
    *   for a prepared statement.
    *
    *   @return boolean
    */
    public static function isPreparedVariable($bject)
    {
        return is_string($bject) && strlen($bject) >= 3
             && ($bject[0] == '?' || $bject[0] == '$')
             && ($bject[1] == '?' || $bject[1] == '$')
        ;
    }//public static function isPreparedVariable($bject)



    /**
    *   Returns a placeholder to be included in the sql statement.
    *   It will be replaced with a real prepared statement variable later on.
    *   Also adds it to the internal placeholder array.
    *
    *   @param string $strVariable  The variable to get a placeholder for
    *   @return string placeholder
    */
    protected function getPreparedVariablePlaceholder($strVariable)
    {
        $strName = substr($strVariable, 2);
        if (!isset($this->arPlaceholders[$strName])) {
            $this->arPlaceholders[$strName] = '@$%_PLACEHOLDER_'
                . count($this->arPlaceholders) . '_%$@';
        }
        return $this->arPlaceholders[$strName];
    }//protected function getPreparedVariablePlaceholder($strVariable)



    public function getPlaceholders()
    {
        return $this->arPlaceholders;
    }//public function getPlaceholders()



    public function getVarAssignments()
    {
        return $this->arVarAssignments;
    }//public function getVarAssignments()



    public function getUsedVarAssignments()
    {
        return $this->arUsedVarAssignments;
    }//public function getUsedVarAssignments()



    public function getUsedVarTypes()
    {
        return $this->arUsedVarTypes;
    }//public function getUsedVarTypes()



    /**
    *   Removes all NULL values from an array and returns it.
    *
    *   @param array $array     Some array
    *   @return array $array without the NULL values.
    */
    protected function removeNull($array)
    {
        foreach ($array as $key => &$value) {
            if ($value === null) {
                unset($array[$key]);
            }
        }
        return $array;
    }//protected static function removeNull($array)



    /**
    *   Removes a leading AND from the where clause which would render
    *   the sql illegal.
    */
    protected function fixWhere($strWhere)
    {
        $strWhere = ltrim($strWhere);
        if (substr($strWhere, 0, 4) == 'AND ') {
            $strWhere = substr($strWhere, 4);
        }
        return $strWhere;
    }//protected function fixWhere($strWhere)



    protected function getSqlVariableName($var, $suffix = '')
    {
        $strSparqlVar = (string)$var;
        if (!isset($this->arVarAssignments[$strSparqlVar][('sqlname'.$suffix)])) {
            $strName = 'v' . $this->nSqlVariableNameCount++;
            $this->arVarAssignments[$strSparqlVar][('sqlname'.$suffix)] = $strName;
        }
        return $this->arVarAssignments[$strSparqlVar][('sqlname'.$suffix)];
    }//protected function getSqlVariableName($var)



    protected function getSqlVariableNameValue($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_value'] = $this->getSqlVariableName($var, 'value');
        return $this->arVarAssignments[$strSparqlVar]['sql_value'];
    }//protected function getSqlVariableNameValue($var)



    protected function getSqlVariableNameIs($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_is'] = $this->getSqlVariableName($var, 'is');
        return $this->arVarAssignments[$strSparqlVar]['sql_is'];
    }//protected function getSqlVariableNameIs($var)



    protected function getSqlVariableNameLanguage($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_lang'] = $this->getSqlVariableName($var, 'lang');
        return $this->arVarAssignments[$strSparqlVar]['sql_lang'];
    }//protected function getSqlVariableNameLanguage($var)



    protected function getSqlVariableNameDatatype($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_type'] = $this->getSqlVariableName($var, 'dt');
        return $this->arVarAssignments[$strSparqlVar]['sql_type'];
    }//protected function getSqlVariableNameDatatype($var)
    
    protected function getSqlVariableNameDatatypeRef($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_dt_ref'] = $this->getSqlVariableName($var, 'dt_ref');
        return $this->arVarAssignments[$strSparqlVar]['sql_dt_ref'];
    }//protected function getSqlVariableNameDatatype($var)

    protected function getSqlVariableNameRef($var)
    {
        $strSparqlVar = (string)$var;
        $this->arVarAssignments[$strSparqlVar]['sql_ref'] = $this->getSqlVariableName($var, 'ref');
        return $this->arVarAssignments[$strSparqlVar]['sql_ref'];
    }


    public function setStatementsTable($tblStatements)
    {
        $this->tblStatements = $tblStatements;
    }//public function setStatementsTable($tblStatements)
}

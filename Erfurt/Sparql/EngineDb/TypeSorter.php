<?php
/**
*   Sorts database types as the Sparql specs want it.
*
*   @author Christian Weiske <cweiske@cweiske.de>
*   @license http://www.gnu.org/licenses/lgpl.html LGPL
*
*   @subpackage sparql
*/
class Erfurt_Sparql_EngineDb_TypeSorter
{
    /**
    *   Defines the sort order for value types in the database,
    *   so that they get sorted correctly as the specs want it.
    *   @var array
    */
    public static $arTypeNumbers = array(
        null    => 0, //empty
        1     => 1, //blank
        0     => 2, //resource
        2     => 3, //literal
    );

    /**
    *   SQL types to cast XSD schema types to, so that they will get
    *   sorted correctly.
    *   @var array
    */
    public static $arCastTypes = array(
        'http://www.w3.org/2001/XMLSchema#integer'  => 'SIGNED INTEGER',
        'http://www.w3.org/2001/XMLSchema#int'  => 'SIGNED INTEGER',
        'http://www.w3.org/2001/XMLSchema#decimal'  => 'DECIMAL',
        'http://www.w3.org/2001/XMLSchema#float'    => 'DECIMAL',
        //yes, this does not work with multiple time zones.
        'http://www.w3.org/2001/XMLSchema#dateTime' => 'CHAR',
        'http://www.w3.org/2001/XMLSchema#date'     => 'CHAR',
        'http://www.w3.org/2001/XMLSchema#anyURI'   => 'CHAR',
    );

    protected $_engine;
    protected $_query;
    
    protected $_sg;

    public function __construct(Erfurt_Sparql_Query $query, $engine)
    {
        $this->_engine = $engine;
        $this->_query = $query;
    }

    /**
    *   Needs to be executed before getOrderifiedSqls and willBeDataDependent
    *
    *   @param SparqlEngineDb_SqlGenerator $sg  SQL generator object
    */
    public function setData($sg)
    {
        $this->arUsedVarTypes        = $sg->getUsedVarTypes();
        $this->arUsedVarAssignments  = $sg->getUsedVarAssignments();
        $this->arVarAssignments      = $sg->getVarAssignments();
        $this->arUnionVarAssignments = $sg->arUnionVarAssignments;
        $this->_sg = $sg;
    }//public function setData(SparqlEngineDb_SqlGenerator $sg)



    /**
    *   Returns an array of sql statements that need to be executed
    *   and deliver the full result set when combined.
    *
    *   Execute setData() before this.
    *
    *   @internal It is not possible (ok, it is - but it would really complicate
    *   the queries and the code here) to use UNION to combine the sqls to
    *   a single one - UNION merges the results and does not keep the order
    *   of the rows. Citing the mysql manual:
    *       Use of ORDER BY for individual SELECT statements implies nothing
    *       about the order in which the rows appear in the final result because
    *       UNION by default produces an unordered set of rows. If ORDER BY
    *       appears with LIMIT, it is used to determine the subset of the
    *       selected rows to retrieve for the SELECT, but does not necessarily
    *       affect the order of those rows in the final UNION result.
    *       If ORDER BY appears without LIMIT in a SELECT, it is
    *       optimized away because it will have no effect anyway.
    *
    *   @param string $strSelect    SELECT clause
    *   @param string $strFrom      FROM clause
    *   @param string $strWhere     WHERE clause
    *   @return array   Array of arrays. Imploding an array will give
    *                    a complete sql statement. The array will have the keys
    *                    select/from/where/order.
    */
    public function getOrderifiedSqls($arSqls)
    {
        if (count($arSqls) == 0) {
            return $arSqls;
        }
        
        $strResultForm = $this->_query->getResultForm();
        if ($strResultForm == 'ask' || $strResultForm == 'count') {
            return array(
                $arSqls
            );
        }
        
        $arSpecial = $this->getSpecialOrderVariables();
        if (count($arSpecial) == 0) {
            $strOrder = $this->getSqlOrderBy();

            foreach ($arSqls as &$arSql) {
                if ($strOrder !== '') {
                    $arSql['order'] = $strOrder;
                }   
            }
            
            return array(
                $arSqls
            );
        }

        $arNewSqls = array();
        foreach ($arSqls as $n => $arSql) {
            $strSelect = $arSql['select'];
            $strFrom   = $arSql['from'];
            $strWhere  = $arSql['where'];
            
            $arTypeSets = $this->orderTypeSets(
                $this->getTypeSets($arSpecial, $strFrom, $strWhere, $n)
            );

            $orderSet = null;
            if (count($arTypeSets) === 0) {
                $arTypeSets[] = array();
                
            } 
            
            $arSqlParts = array();
            $arSql['where'] .= $this->getTypesetWhereClause($arTypeSets[0], $n);
            $arSql['order']  = $this->getSqlOrderBy($arTypeSets[0], $n);
            $arSqlParts[] = $arSql;
            
            $arNewSqls[] = $arSqlParts;
        }
      
        return $arNewSqls;
    }//public function getOrderifiedSqls($arUsedVarAssignments, $strSelect, $strFrom, $strWhere)



    /**
    *   Returns wether the returned queries will depend on the data or not.
    *   If the queries depend on the data, they cannot be prepare()d and
    *   thus won't be that fast when executing.
    *
    *   Execute setData() before this.
    *
    *   @return boolean
    */
    public function willBeDataDependent()
    {
        $strResultForm = $this->_query->getResultForm();
        return !(
            $strResultForm == 'ask' || $strResultForm == 'count'
            || count($this->getSpecialOrderVariables()) == 0
        );
    }//public function willBeDataDependent()



    /**
    *   Returns an array of variables that the result is going to be
    *   ordered by and that need to be sorted multiple times
    *   (because they may contain different data types)
    *
    *   @return array Array of sparql variable names
    */
    protected function getSpecialOrderVariables()
    {
        $arSM = $this->_query->getSolutionModifier();
        if ($arSM['order by'] === null) {
            return array();
        }

        $arSpecial = array();
        foreach ($arSM['order by'] as $arVar) {
            if ($this->isSpecialOrderVariable($arVar['val'])) {
                $arSpecial[] = $arVar['val'];
            }
        }
        return $arSpecial;
    }//protected function getSpecialOrderVariables()



    /**
    *   Checks if a given variable name is a variable that
    *   needs special care when used in ORDER BY statements.
    *
    *   @param string $strVar SPARQL variable name
    *   @return boolean true if the variable needs special care
    */
    protected function isSpecialOrderVariable($strVar)
    {
        return !isset($this->arUsedVarTypes[$strVar]['s'])
            && !isset($this->arUsedVarTypes[$strVar]['p']);
    }//protected function isSpecialOrderVariable($arVar)



    /**
    *   Determines the type sets in the query results.
    *   A type set is a distinct set of variables and their types,
    *   e.g. the variable and its type (r/b/l) and its datatype
    *   if its an object.
    *
    *   @param array $arSpecialVars     Special variables as returned by
    *                                   getSpecialOrderVariables()
    *   @param string $strFrom          FROM part of the sql query
    *   @param string $strWhere         WHERE part of the sql query
    *
    *   @return array   Key is the sparql variable name, value is an
    *                   array. This one has one key 'type' with a
    *                   value of b/l/r. It might have another key
    *                   'datatype' with the resource's datatype.
    */
    protected function getTypeSets($arSpecialVars, $strFrom, $strWhere, $nUnion)
    {
        $arSel = array();
        foreach ($arSpecialVars as $strSparqlVar) {
            if (!isset($this->arVarAssignments[$strSparqlVar])) {
                require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
                throw new Erfurt_Sparql_EngineDb_SqlGeneratorException('Variable "' . $strSparqlVar . '" not selected.');
            }
   
            if ($this->arUnionVarAssignments[$nUnion][$strSparqlVar][1] === 'o') {
                $arSel[] = $this->arUnionVarAssignments[$nUnion][$strSparqlVar][0] . '.' .
                    $this->_sg->arTableColumnNames['datatype']['value'] 
                    . ' as "' . $strSparqlVar . '-datatype"';
            }
            $strTypeCol = $this->arUnionVarAssignments[$nUnion][$strSparqlVar][1] === 'o'
                ? $this->_sg->arTableColumnNames['o']['is'] : $this->_sg->arTableColumnNames['s']['is'];
            $this->arVarAssignments[$strSparqlVar][2] = $strTypeCol;
            $arSel[] = $this->arUnionVarAssignments[$nUnion][$strSparqlVar][0] . '.' . $strTypeCol
                . ' as "' . $strSparqlVar . '-type"';
        }

        
        $sql      = 'SELECT DISTINCT ' . implode(',', $arSel) . ' ' . $strFrom . $strWhere;

        $arResult = $this->_engine->sqlQuery($sql);

        if ($arResult === false) {
            require_once 'Erfurt/Sparql/EngineDb/SqlGeneratorException.php';
            throw new Erfurt_Sparql_EngineDb_SqlGeneratorException('Error reading typesets: ' . $sql);
        }

        $arTypes = array();

        foreach ($arResult as $arRow) {
            $nLine = count($arTypes);
            foreach ($arRow as $key => $value) {
                list($strSparqlVar, $strType) = explode('-', $key);
                
                if (($value === null || $value === '') && $strType !== 'type') {
                    $value = 'http://www.w3.org/2001/XMLSchema#string';
                } 
                
                if (isset($arTypes[0][$strSparqlVar][$strType])) {
                    $arTypes[0][$strSparqlVar][$strType][] = $value;
                } else {
                    $arTypes[0][$strSparqlVar][$strType] = array($value);
                }
                
                
            }
        }
        
        if (count($arTypes) > 0) {
            foreach ($arTypes[0] as &$var) {
                $var['type'] = array_values(array_unique($var['type']));
                $var['datatype'] = array_values(array_unique($var['datatype']));
            }
        }
        

        //$arTypes = array_unique($arTypes);

        return $arTypes;
    }



    /**
    *   Takes an array of type sets (as returned by getTypeSets()) and
    *   sorts the variables according to the SPARQL specs.
    *
    *   @param array $arTypes Array of type sets
    *   @return array Ordered array of type sets
    */
    protected function orderTypeSets($arTypes)
    {
        $arSM = $this->_query->getSolutionModifier();
        if ($arSM['order by'] !== null) {
            $this->arDirection = array();
            foreach ($arSM['order by'] as $arVar) {
                $this->arDirection[$arVar['val']] =
                    (strtoupper($arVar['type']) == 'ASC' ? 1 : -1);
            }
        }

        usort($arTypes, array($this, 'compareTypeSet'));

        return $arTypes;
    }//protected function orderTypeSets($arTypes)



    /**
    *   Compares two type sets. Works like a normal comparision
    *   method that returns -1/0/1 for use in usort()
    *
    *   @param array $arTs1     First typeset
    *   @param array $arTs2     Second typeset
    *   @return int Comparison value
    */
    public function compareTypeSet($arTs1, $arTs2)
    {
        foreach ($arTs1 as $strSparqlVar => $arType1) {
            //compare types
            $n = self::$arTypeNumbers[$arType1['type']]
                - self::$arTypeNumbers[$arTs2[$strSparqlVar]['type']];
            if ($n != 0) {
                //and take ASC/DESC into account
                return $n * $this->arDirection[$strSparqlVar];
            }

            //compare the datatypes
            $n = self::compareXsdType(
                $arType1['datatype'],
                $arTs2[$strSparqlVar]['datatype']
            );
            //if they are not equal, return the value
            if ($n != 0) {
                //and take ASC/DESC into account
                return $n * $this->arDirection[$strSparqlVar];
            }
        }

        //they are equal
        return 0;
    }//public function compareTypeSet($arTs1, $arTs2)



    /**
    *   Compares two XSD data types and returns the comparison number.
    *
    *   @param string $strType1     First data type
    *   @param string $strType2     Second data type
    *   @return int     Comparison number (<0 if $strType1 is less than
    *                   $strType2, 0 if equal, >0 if type2 is greater)
    */
    public static function compareXsdType($strType1, $strType2)
    {
        return self::getXsdTypeNumber($strType1) - self::getXsdTypeNumber($strType2);
    }//public static function compareXsdType($strType1, $strType2)



    /**
    *   Returns the type number for an xsd data type.
    *
    *   @param string $strType  XSD data type
    *   @return int  Some integer to compare two types.
    */
    public static function getXsdTypeNumber($strType)
    {
        if ($strType === null) {
            return 0;
        } else if ($strType == '') {
            return 1;
        } else {
            return 2;
        }
    }//public static function getXsdTypeNumber($strType)



    /**
    *   Returns the ORDER BY sql query string
    *   if neccessary for the query. The returned string
    *   already has ORDER BY prefixed.
    *
    *   @internal Also takes care of casting the data if the type
    *   is listed in $arCastTypes. See getCastMethod() for more info.
    *
    *   @param arrray $arTypeSet Single typeset
    *   @return string      ORDER BY ... string or empty string
    */
    function getSqlOrderBy($arTypeSet = array(), $n = 0)
    {
        $arSM = $this->_query->getSolutionModifier();

        if ($arSM['order by'] === null) {
            return '';
        }

        #if (count($arTypeSet) === 0) {
        #    return '';
        #}

//var_dump($arTypeSet);
//var_dump($this->arUnionVarAssignments);

        $sqlOrder = array();
        foreach ($arSM['order by'] as $arVar) {
            $strSparqlVar = $arVar['val'];
            if (isset($this->arUnionVarAssignments[$n][$strSparqlVar])) { 
                $dt = null;
                if (isset($arTypeSet[$strSparqlVar])) {
                    foreach ($arTypeSet[$strSparqlVar]['datatype'] as $datatype) {
                        if ($datatype !== 'http://www.w3.org/2001/XMLSchema#string') {
                            $dt = $datatype;
                            break;
                        }
                    }
                }
                if (null === $dt) {
                    $dt = 'http://www.w3.org/2001/XMLSchema#string';
                }
                
                if (!isset($dt) || $dt == '' || $dt == 'String' || $dt == 'http://www.w3.org/2001/XMLSchema#string') {
                    $sqlOrder[] = $this->arUnionVarAssignments[$n][$strSparqlVar][0] . '.' . $this->arUnionVarAssignments[$n][$strSparqlVar][1] . ' ' . strtoupper($arVar['type']);
                } else {
                    try {
                        $sqlOrder[] = self::getCastMethod(
                            $dt,
                            $this->arUnionVarAssignments[$n][$strSparqlVar][0] . '.' . $this->arUnionVarAssignments[$n][$strSparqlVar][1]
                        ) . ' ' . strtoupper($arVar['type']);
                    } catch (Exception $e) {
                        $sqlOrder[] = $this->arUnionVarAssignments[$n][$strSparqlVar][0] . '.' . $this->arUnionVarAssignments[$n][$strSparqlVar][1] . ' ' . strtoupper($arVar['type']);
                    }
                    
                }
            }
        }

        if (count($sqlOrder) === 0) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Something went wrong with ORDER BY.');
        }
//var_dump($sqlOrder);exit;
        return ' ORDER BY ' . implode(', ', $sqlOrder);
    }//function getSqlOrderBy($arTypeSet = array())



    /**
    *   Returns the SQL statement needed to case the given variable to
    *   the given type.
    *
    *   @param string $strType      XML data type
    *   @param string $strSqlVar    SQL variable name
    *   @return string  SQL command to cast the variable
    */
    protected static function getCastMethod($strType, $strSqlVar)
    {
        if (isset(self::$arCastTypes[$strType])) {
            return 'CAST(' . $strSqlVar . ' as ' . self::$arCastTypes[$strType] . ')';
        } else {
            
            //unsupported type!
            throw new Exception('Unsupported cast type in order by: ' . $strType);
            return $strSqlVar;
        }
    }//protected static function getCastMethod($strType, $strSqlVar)



    /**
    *   Creates and returns the SQL WHERE clauses needed to get only
    *   data in the given typeset.
    *
    *   @param array $arTypeSet     Typeset
    *   @return string  Clauses for the WHERE part in an SQL query
    */
    protected function getTypesetWhereClause($arTypeSet, $n)
    {
        $strWhereTypes = '';
        foreach ($arTypeSet as $strSparqlVar => $arTypeArray) {
            $strWhereTypes .= ' AND (';
            foreach ($arTypeArray['type'] as $i => $arType) {
                if ($i === 0) {
                    $strWhereTypes .= $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                        . '.' . $this->arVarAssignments[$strSparqlVar][2]
                        . $this->getStringNullComparison($arType);
                } else {
                     $strWhereTypes .= ' OR ' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                            . '.' . $this->arVarAssignments[$strSparqlVar][2]
                            . $this->getStringNullComparison($arType);
                }
            }
            if (count($arTypeArray['type']) === 0) {
                $strWhereTypes .= '1';
            } else {
                $strWhereTypes .= '';
            }
            
            if (isset($arTypeArray['datatype']) && count($arTypeArray['datatype']) > 0) {
                $strWhereTypes .= ' OR ';
                foreach ($arTypeArray['datatype'] as $i => $arType) {
                    if ($i === 0) {
                        if ($arType === 'http://www.w3.org/2001/XMLSchema#string') {
                            $strWhereTypes .= '(' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                . $this->getStringNullComparison($arType);

                            $strWhereTypes .= ' OR ' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                . '="")';
                        } else {
                            $strWhereTypes .= $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                . $this->getStringNullComparison($arType);
                        }
                    }
                    else {
                         if ($arType === 'http://www.w3.org/2001/XMLSchema#string') {
                             $strWhereTypes .= 'OR (' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                 . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                 . $this->getStringNullComparison($arType);

                             $strWhereTypes .= ' OR ' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                 . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                 . '="")';
                         } else {
                             $strWhereTypes .= ' OR ' . $this->arUnionVarAssignments[$n][$strSparqlVar][0]
                                 . '.' . $this->_sg->arTableColumnNames['datatype']['value']
                                 . $this->getStringNullComparison($arType);
                         }
                    }
                }
                
                $strWhereTypes .= ')';
            }
        }
        
        return $strWhereTypes;
    }

    /**
    *   Returns the correct sql string comparison method.
    *
    *   @internal If the string is NULL, an "IS NULL" sql statment
    *   will be returned, and a normal "= 'something'" if it is
    *   a normal string.
    */
    protected function getStringNullComparison($str)
    {
        if ($str === null) {
            return ' IS NULL';
        } else if (is_int($str)) {
            return "=$str";
        } else {
            return "='$str'";
        }
    }//protected function getStringNullComparison($str)

}

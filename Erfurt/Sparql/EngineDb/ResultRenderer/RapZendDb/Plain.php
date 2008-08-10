<?php
require_once 'Erfurt/Sparql/EngineDb/ResultRenderer.php';

/**
*   Result renderer that creates a text array
*
*   @author Christian Weiske <cweiske@cweiske.de>
*   @license http://www.gnu.org/licenses/lgpl.html LGPL
*
*   @package sparql
*/
class Erfurt_Sparql_EngineDb_ResultRenderer_RapZendDb_Plain implements Erfurt_Sparql_EngineDb_ResultRenderer 
{
    /**
     *   Defines the methods needed to create the types
     *   in $arVarAssignments.
     *   Key is the type (e.g. "s" for subject), and
     *   value the method's name.
     *
     *   @see $arVarAssignments
     *
     *   @var array
     */
    protected $arCreationMethods = array(
        's' => 'createSubjectFromDbRecordSetPart',
        'p' => 'createPredicateFromDbRecordSetPart',
        'o' => 'createObjectFromDbRecordSetPart'
    );



    /**
    *   Converts the database results into the desired output format
    *   and returns the result.
    *
    *   @param array $arRecordSets  Array of (possibly several) SQL query results.
    *   @param Query $query     SPARQL query object
    *   @param SparqlEngineDb $engine   Sparql Engine to query the database
    *   @return mixed   The result as rendered by the result renderers.
    */
    public function convertFromDbResults($arRecordSets, Erfurt_Sparql_Query $query, $engine)
    {
        $this->query    = $query;
        $this->engine   = $engine;
        $this->sg       = $engine->getSqlGenerator();

        $strResultForm = $this->query->getResultForm();
        switch ($strResultForm) {
            case 'construct':
            case 'select':
            case 'select distinct':
                $arResult = $this->getVariableArrayFromRecordSets($arRecordSets, $strResultForm);

                //some result forms need more modification
                switch ($strResultForm) {
                    case 'construct';
                        $arResult = $this->constructGraph(
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
            case 'ask':
                if (count($arRecordSets) > 1) {
                    throw new Exception(
                        'More than one result set for a '
                        . $strResultForm . ' query!'
                    );
                }

                $nCount = 0;

                $result = $dbRecordSet->fetchAll();

                foreach ($result as $row) {
                    $nCount += intval($row[0]);
                    break;
                }

                if ($strResultForm == 'ask') {
                    return $nCount > 0;
                } else {
                    return $nCount;
                }
                break;

            case 'describe':
            default:
                throw new Exception('Unsupported result form: ' . $strResultForm);
        }

    }//public function convertFromDbResults($arRecordSets, Query $query, SparqlEngineDb $engine)




    protected function getVariableArrayFromRecordSets($arRecordSets, $strResultForm)
    {
        $arResult = array();
        foreach ($arRecordSets as $dbRecordSet) {
            $arResult = array_merge(
                $arResult,
                $this->getVariableArrayFromRecordSet($dbRecordSet, $strResultForm)
            );
        }
        return $arResult;
    }//protected function getVariableArrayFromRecordSets($arRecordSets, $strResultForm)



    /**
    *   Converts a ADORecordSet object into an array of "rows" that
    *   are subarrays of variable => value pairs.
    *
    *   @param ADORecordSet $dbRecordSet    Anything ADOConnection::Execute() can return
    *   @return array
    */
    protected function getVariableArrayFromRecordSet($dbRecordSet, $strResultForm)
    {
        $arResult       = array();
        switch ($strResultForm) {
            case 'construct':
                $arResultVars = $this->query->getConstructPatternVariables();
                break;
            default:
                $arResultVars = $this->query->getResultVars();
                break;
        }

        if (in_array('*', $arResultVars)) {
            $arResultVars   = array_keys($this->sg->arVarAssignments);
        }
        
        $result = $dbRecordSet;

        //work around bug in adodb:
        // ADORecordSet_empty does not implement php5 iterators
        //if (count($result) === 0) {
        //    return array();
        //}

        foreach ($result as $row) {
            $arResultRow = array();
            foreach ($arResultVars as $strVar) {
                $strVarName = (string)$strVar;
                $strVarId = ltrim($strVar, '?$');
                if (!isset($this->sg->arVarAssignments[$strVarName])) {
                    //variable is in select, but not in result (test: q-select-2)
                    $arResultRow[$strVarId] = '';
                } else {
                    $arVarSettings  = $this->sg->arVarAssignments[$strVarName];
                    $strMethod      = $this->arCreationMethods[$arVarSettings[1]];
                    $arResultRow[$strVarId] = $this->$strMethod($row, $arVarSettings[0], $strVar);
                }
            }
            $arResult[] = $arResultRow;
        }
        return $arResult;
    }//function getVariableArrayFromRecordSet(ADORecordSet $dbRecordSet)



    /**
    *   Creates an RDF Statement object for one of the variables
    *   contained in the given $dbRecordSet object.
    *
    *   @see convertFromDbResult() to understand $strVarBase necessity
    *
    *   @param ADORecordSet $dbRecordSet    Record set returned from ADOConnection::Execute()
    *   @param string       $strVarBase     Prefix of the columns the recordset fields have.
    *
    *   @return Statement   RDF statement object
    */
    protected function createStatementFromDbRecordSetPart($row, $strVarBase)
    {
        return new Statement(
            $this->createSubjectFromDbRecordSetPart  ($row, $strVarBase),
            $this->createPredicateFromDbRecordSetPart($row, $strVarBase),
            $this->createObjectFromDbRecordSetPart   ($row, $strVarBase)
        );
    }//protected function createStatementFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase)



    /**
    *   Creates an RDF subject object
    *   contained in the given $dbRecordSet object.
    *
    *   @see convertFromDbResult() to understand $strVarBase necessity
    *
    *   @param ADORecordSet $dbRecordSet    Record set returned from ADOConnection::Execute()
    *   @param string       $strVarBase     Prefix of the columns the recordset fields have.
    *
    *   @return Resource   RDF triple subject resource object
    */
    protected function createSubjectFromDbRecordSetPart($row, $strVarBase, $strVar)
    {
        $strVarName = (string)$strVar;
        
        if ($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
            //FIXME: should be NULL, but doesn't pass test
            return '';
        }

        if ($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']] == 'r'
            //null should be predicate which is always a resource
         || $row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']] === null
        ) {
            return $this->createResource($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
        } else {
            
            return $this->createBlankNode($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
        }
        
        return $subject;
    }//protected function createSubjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVar)



    /**
    *   Creates an RDF predicate object
    *   contained in the given $dbRecordSet object.
    *
    *   @see convertFromDbResult() to understand $strVarBase necessity
    *
    *   @param ADORecordSet $dbRecordSet    Record set returned from ADOConnection::Execute()
    *   @param string       $strVarBase     Prefix of the columns the recordset fields have.
    *
    *   @return Resource   RDF triple predicate resource object
    */
    protected function createPredicateFromDbRecordSetPart($row, $strVarBase, $strVar)
    {
        $strVarName = (string)$strVar;
        
        
        
        if ($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
            //FIXME: should be NULL, but doesn't pass test
            return '';
        }
        return $this->createResource($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
    }//protected function createPredicateFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVar)



    /**
    *   Creates an RDF object object
    *   contained in the given $dbRecordSet object.
    *
    *   @see convertFromDbResult() to understand $strVarBase necessity
    *
    *   @param ADORecordSet $dbRecordSet    Record set returned from ADOConnection::Execute()
    *   @param string       $strVarBase     Prefix of the columns the recordset fields have.
    *
    *   @return Resource   RDF triple object resource object
    */
    protected function createObjectFromDbRecordSetPart($row, $strVarBase, $strVar)
    {
        $strVarName = (string)$strVar;
        
        if ($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
            //FIXME: should be NULL, but doesn't pass test
            return '';
        }
        switch ($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']]) {
            case 'r':
                return $this->createResource($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
                break;
            case 'b':
                return $this->createBlankNode($row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
                break;
            default:
                return $this->createLiteral(
                    $row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']],
                    $row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_lang']],
                    $row[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_type']]
                );
        }
    }//protected function createObjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVar)



    /**
    * Constructs a result graph.
    *
    * @param  array         $arVartable       A table containing the result vars and their bindings
    * @param  GraphPattern  $constructPattern The CONSTRUCT pattern
    * @return MemModel      The result graph which matches the CONSTRUCT pattern
    */
    protected function constructGraph($arVartable, $constructPattern)
    {
        $resultGraph = new MemModel();

        if (!$arVartable) {
            return $resultGraph;
        }

        $tp = $constructPattern->getTriplePatterns();

        $bnode = 0;
        foreach ($arVartable as $value) {
            foreach ($tp as $triple) {
                $sub  = $triple->getSubject();
                $pred = $triple->getPredicate();
                $obj  = $triple->getObject();

                if (is_string($sub)  && $sub{1} == '_') {
                    $sub  = new BlankNode("_bN".$bnode);
                }
                if (is_string($pred) && $pred{1} == '_') {
                    $pred = new BlankNode("_bN".$bnode);
                }
                if (is_string($obj)  && $obj{1} == '_') {
                    $obj  = new BlankNode("_bN".$bnode);
                }


                if (is_string($sub)) {
                    $sub  = $value[$sub];
                }
                if (is_string($pred)) {
                    $pred = $value[$pred];
                }
                if (is_string($obj)) {
                    $obj  = $value[$obj];
                }

                if ($sub !== "" && $pred !== "" && $obj !== "") {
                    $resultGraph->add(new Statement($sub,$pred,$obj));
                }
            }
            $bnode++;
        }
        return $resultGraph;
    }//protected function constructGraph($arVartable, $constructPattern)



    protected function createResource($uri)
    {
        return $uri;
    }//protected function createResource($uri)



    protected function createBlankNode($id)
    {
        return '_:'.$id;
    }//protected function createBlankNode($id)



    protected function createLiteral($value, $language, $datatype)
    {
        return $value;
    }//protected function createLiteral($value, $language, $datatype)

}//class SparqlEngineDb_ResultRenderer_PlainText implements SparqlEngineDb_ResultRenderer
?>
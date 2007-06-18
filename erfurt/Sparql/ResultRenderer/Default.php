<?php
class Erfurt_Sparql_ResultRenderer_Default implements SparqlEngineDb_ResultRenderer {
	
	private $model;
	private $class;
	
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

		public function __construct($model, $class = null) {

			$this->model = $model;
			$this->class = $class;
		}


	    /**
	    *   Converts the database results into the desired output format
	    *   and returns the result.
	    *
	    *   @param array $arRecordSets  Array of (possibly several) SQL query results.
	    *   @param Query $query     SPARQL query object
	    *   @param SparqlEngineDb $engine   Sparql Engine to query the database
	    *   @return mixed   The result as rendered by the result renderers.
	    */
	    public function convertFromDbResults($arRecordSets, Query $query, SparqlEngineDb $engine)
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
	                $dbRecordSet = reset($arRecordSets);
	                foreach ($dbRecordSet as $row) {
	                    $nCount += intval($row['count']);
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
	    protected function getVariableArrayFromRecordSet(ADORecordSet $dbRecordSet, $strResultForm)
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

	        //work around bug in adodb:
	        // ADORecordSet_empty does not implement php5 iterators
	        if ($dbRecordSet->RowCount() <= 0) {
	            return array();
	        }

	        foreach ($dbRecordSet as $row) {
	            $arResultRow = array();
	            foreach ($arResultVars as $strVarName) {
	                if (!isset($this->sg->arVarAssignments[$strVarName])) {
	                    //variable is in select, but not in result (test: q-select-2)
	                    $arResultRow[$strVarName] = '';
	                } else {
	                    $arVarSettings  = $this->sg->arVarAssignments[$strVarName];
	                    $strMethod      = $this->arCreationMethods[$arVarSettings[1]];
	                    $arResultRow[$strVarName] = $this->$strMethod($dbRecordSet, $arVarSettings[0], $strVarName);
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
	    protected function createStatementFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase)
	    {
	        return new Statement(
	            $this->createSubjectFromDbRecordSetPart  ($dbRecordSet, $strVarBase),
	            $this->createPredicateFromDbRecordSetPart($dbRecordSet, $strVarBase),
	            $this->createObjectFromDbRecordSetPart   ($dbRecordSet, $strVarBase)
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
	    protected function createSubjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)
	    {
	        if ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
	            //FIXME: should be NULL, but doesn't pass test
	            return '';
	        }

	        if ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']] == 'r'
	            //null should be predicate which is always a resource
	         || $dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']] === null
	        ) {
	            $subject    = $this->model->resourceF($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
	        } else {
	            $subject    = new BlankNode($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
	        }
	        return $subject;
	    }//protected function createSubjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)



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
	    protected function createPredicateFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)
	    {
	        if ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
	            //FIXME: should be NULL, but doesn't pass test
	            return '';
	        }
	        $predicate      = $this->model->resourceF($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
	        return $predicate;
	    }//protected function createPredicateFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)



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
	    protected function createObjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)
	    {
	        if ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']] === null) {
	            //FIXME: should be NULL, but doesn't pass test
	            return '';
	        }
	        switch ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_is']]) {
	            case 'r':
	                $object = $this->model->resourceF($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
	                break;
	            case 'b':
	                $object = new BlankNode($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']]);
	                break;
	            default:
// TODO check Literal creation (what about the datatype?)
	                $object = $this->model->literalF(
	                    $dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_value']],
	                    $dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_lang']]
	                );
	                if ($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_type']]) {
	                    $object->setDatatype($dbRecordSet->fields[$strVarBase . '.' . $this->sg->arVarAssignments[$strVarName]['sql_type']]);
	                }
	        }
	        return $object;
	    }//protected function createObjectFromDbRecordSetPart(ADORecordSet $dbRecordSet, $strVarBase, $strVarName)



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

	        $tp = $constructPattern->getTriplePattern();

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
}
?>
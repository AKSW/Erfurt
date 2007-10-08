<?php

require_once RDFAPI_INCLUDE_DIR . 'sparql/SparqlEngineDb/ResultRenderer/PlainText.php';

class Erfurt_Sparql_ResultRenderer_Plain extends SparqlEngineDb_ResultRenderer_PlainText
{	
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
            foreach ($arResultVars as $strVar) {
                $strVarName = (string) $strVar;
				$strVarId = ltrim($strVar, '?$');
                if (!isset($this->sg->arVarAssignments[$strVarName])) {
                    //variable is in select, but not in result (test: q-select-2)
                    $arResultRow[$strVarId] = '';
                } else {
                    $arVarSettings  = $this->sg->arVarAssignments[$strVarName];
                    $strMethod      = $this->arCreationMethods[$arVarSettings[1]];
                    $arResultRow[$strVarId] = $this->$strMethod($dbRecordSet, $arVarSettings[0], $strVar);
                }
            }
            $arResult[] = $arResultRow;
        }
        return $arResult;
    }//function getVariableArrayFromRecordSet(ADORecordSet $dbRecordSet)

    protected function createResource($uri)
    {
        return $uri;
    }//protected function createResource($uri)



    protected function createBlankNode($id)
    {
        return $id;
    }//protected function createBlankNode($id)



    protected function createLiteral($value, $language, $datatype)
    {
        $v = $value;
        if ($language != null) {
            $v .= '@' . $language;
        }
        if ($datatype != null) {
            $v .= '^^' . $datatype;
        }
        return $v;
    }//protected function createLiteral($value, $language, $datatype)

}//class SparqlEngineDb_ResultRenderer_PlainText implements SparqlEngineDb_ResultRenderer

?>

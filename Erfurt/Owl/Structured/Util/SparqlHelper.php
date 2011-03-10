<?php

class Erfurt_Owl_Structured_Util_SparqlHelper {

    private static $i = 0;
    const VAR_ID = "o";
    private $q;
    private $lastVar;

    public function __construct(array $from, $uri)
    {
        $this->q = new Erfurt_Sparql_Query2();
        foreach($from as $from1) {
            $this->q->addFrom(new Erfurt_Sparql_Query2_IriRef($from1));
        }
        $v1 = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $this->lastVar = $v1;
        $firstTriple = new Erfurt_Sparql_Query2_Triple(
            new Erfurt_Sparql_Query2_IriRef($uri),
            new Erfurt_Sparql_Query2_IriRef(RDFS_SUBCLASSOF),
            $v1);
        $this->q->addElement($firstTriple);
        $this->q->getOrder()->add($v1);
    }

    /**
     * recursive function
     * current limitations: multiple values in subclass not supported
     */
    public function getStructuredOwl(Erfurt_Sparql_Query2 $q = null, Erfurt_Sparql_Query2_Var $variable=null)
    {
        $q = ($q) ? $q : $this->q;
        $variable = ($variable) ? $variable : $this->lastVar;
        $structured = new Erfurt_Owl_Structured_ClassExpression();
        $structuredArray = array();
        $rowsNumber = Erfurt_Owl_Structured_Util_SparqlStoreHelper::count($q);
        if ($rowsNumber>1) {
            for ($i = 0; $i < $rowsNumber; $i++) {
                $q->setLimit(1);
                $q->setOffset($i);
                $structuredArray = array_merge($structuredArray, $this->getStructuredOwl($q, $variable));
            }
        } else {
            if ($x = Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($q, $variable, "isBlank")) {
                $p = new Erfurt_Sparql_Query2_IriRef(RDF_TYPE);
                $o = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
                $triple = new Erfurt_Sparql_Query2_Triple($variable, $p, $o);
                $q->addElement($triple);
                $actionType = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $o);
                switch ($actionType) {
                case OWL_CLASS:
                case RDFS_DATATYPE:
                    $structured->addElement($this->getConnectives($q, $variable));
                    break;
                case OWL_RESTRICTION:
                    $structured->addElement($this->getRestriction($q, $variable));
                    break;
                default:
                    throw new Exception("$actionType not implemented yet");
                    break;
                }
                $structuredArray []= $structured;
            } else {
                // it is a class expression axiom, or done?
                $structuredArray [] = $this->getElement($q, $variable);
            }
        }
        return $structuredArray;
    }

    private function getRestriction(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $variable)
    {
        $retval = null;
        $restrictionVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $onPropertyVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $classVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $valueVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $datatypeVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $onProperty = new Erfurt_Sparql_Query2_IriRef(OWL_ONPROPERTY);
        $rdfType = new Erfurt_Sparql_Query2_IriRef(RDF_TYPE);
        $onClass = new Erfurt_Sparql_Query2_IriRef(OWL_ONCLASS);
        $onDataRange = new Erfurt_Sparql_Query2_IriRef(OWL_ONDATARANGE);

        $triple1 = new Erfurt_Sparql_Query2_Triple($variable, $rdfType, new Erfurt_Sparql_Query2_IriRef(OWL_RESTRICTION));
        $triple2 = new Erfurt_Sparql_Query2_Triple($variable, $onProperty, $onPropertyVar);
        $triple3 = new Erfurt_Sparql_Query2_Triple($variable, $restrictionVar, $valueVar);

        $q->addElements(array($triple1, $triple2, $triple3));
        $myQuery = clone $q;
        $myQuery->setQueryType('SELECT');

        $optionalOnClass = new Erfurt_Sparql_Query2_OptionalGraphPattern();
        $optionalOnClass->addElement(new Erfurt_Sparql_Query2_Triple($variable, $onClass, $classVar));
        $optionalOnDataRange = new Erfurt_Sparql_Query2_OptionalGraphPattern();
        $optionalOnDataRange->addElement(new Erfurt_Sparql_Query2_Triple($variable, $onDataRange, $datatypeVar));
        $myQuery->addElement($optionalOnClass);
        $myQuery->addElement($optionalOnDataRange);
        $filter1 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $restrictionVar, $rdfType
                )));
        $myQuery->addElement($filter1);

        $filter2 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $restrictionVar, $onProperty
                )));
        $myQuery->addElement($filter2);

        $filter3 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $restrictionVar, $onClass
                )));
        $myQuery->addElement($filter3);

        $filter4 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $restrictionVar, $onDataRange
                )));
        $myQuery->addElement($filter4);

        $restrictionType =     Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($myQuery, $restrictionVar);
        $restrictionProperty = $this->getElement($myQuery, $onPropertyVar);
        $restrictionValue =    $this->getElement($myQuery, $valueVar);
        $onClassValue =        $this->getElement($myQuery, $classVar);
        $onDataRangeValue =    $this->getElement($myQuery, $datatypeVar);

        switch ($restrictionType) {
        case OWL_CARDINALITY:
        case OWL_QUALIFIEDCARDINALITY:
            $structuredClass = "ExactCardinality";
            break;
        case OWL_ALLVALUESFROM:
            $structuredClass = "AllValuesFrom";
            break;
        case OWL_SOMEVALUESFROM:
            $structuredClass = "SomeValuesFrom";
            break;
        case OWL_HASVALUE:
            $structuredClass = "HasValue";
            break;
        case OWL_HASSELF:
            $structuredClass = "HasSelf";
            break;
        case OWL_MAXQUALIFIEDCARDINALITY:
        case OWL_MAXCARDINALITY:
            $structuredClass = "MaxCardinality";
            break;
        case OWL_MINQUALIFIEDCARDINALITY:
        case OWL_MINCARDINALITY:
            $structuredClass = "MinCardinality";
            break;
        default:
            throw new Exception("$restrictionType is not implemented yet...");
            break;
        }
        $cName = "Erfurt_Owl_Structured_" . ($onDataRangeValue ? "DataPropertyRestriction_Data" : "ObjectPropertyRestriction_Object") . $structuredClass;
        $retval = new $cName($restrictionProperty, $restrictionValue, ($onClassValue ? $onClassValue : ($onDataRangeValue? $onDataRangeValue : null)));
        return $retval;
    }

    private function getConnectives(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $variable, $dataRangeExpression = false)
    {
        $rdfType = new Erfurt_Sparql_Query2_IriRef(RDF_TYPE);
        $connectiveVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $valueVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $triple1 = new Erfurt_Sparql_Query2_Triple($variable, $connectiveVar, $valueVar);

        $filter1 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $connectiveVar, $rdfType
                )));
        $myQuery = clone $q;
        $myQuery->addElement($filter1);
        $myQuery->addElement($triple1);

        $structuredClass = "";

        $connAction = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($myQuery, $connectiveVar);
        switch ($connAction) {
        case OWL_UNIONOF:
            $structuredClass = "UnionOf";
            break;
        case OWL_INTERSECTIONOF:
            $structuredClass = "IntersectionOf";
            break;
        case OWL_COMPLEMENTOF:
        case OWL_DATATYPECOMPLEMENTOF:
            $structuredClass = "ComplementOf";
            break;
        case OWL_ENUMERATION:
            $structuredClass = "OneOf";
            break;
        default:
            // TODO add support for datatyperestriction
            throw new Exception("$connAction not yet imlemented");
            break;
        }
        $className = "Erfurt_Owl_Structured_" . ($dataRangeExpression ? "DataRange_Data" : "ClassExpression_Object") . $structuredClass;
        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($myQuery, $valueVar, "isBlank")) {
            if (class_exists($className)) {
                $structured = new $className($this->getOwlList($myQuery, $valueVar, null));
            } else throw new Exception("$className does not exist!");
        } else {
            $structured = new $className($this->getElement($myQuery, $valueVar));
        }
        return $structured;
    }

    /**
      * Recursive class for generating Structured Owl List from a given variable
      * @returns a Structured Owl List
      *
     **/
    private function getOwlList(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $var, Erfurt_Owl_Structured_OwlList $list = null)
    {
        if (!$list)
            $list = new Erfurt_Owl_Structured_OwlList();
        $firstIri = new Erfurt_Sparql_Query2_IriRef(RDF_FIRST);
        $restIri = new Erfurt_Sparql_Query2_IriRef(RDF_REST);
        $nil = new Erfurt_Sparql_Query2_IriRef(RDF_NIL);
        $firstVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $restVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $tripleFirst = new Erfurt_Sparql_Query2_Triple($var, $firstIri, $firstVar);
        $tripleRest = new Erfurt_Sparql_Query2_Triple($var, $restIri, $restVar);
        $q->addElements(array($tripleFirst, $tripleRest));
        $list->addElement($this->getElement($q, $firstVar));
        // recursion...
        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $restVar) == RDF_NIL) {
            return $list;
        } else {
            $list->addAllElements($this->getOwlList($q, $restVar, null));
            return $list;
        }
    }

    /**
      * Method for creating structured Owl class from ubknown element
      * Element can be a blank node or iri
     **/
    private function getElement(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $var)
    {
        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($q, $var, "isBlank")) {
            $retval = $this->getStructuredOwl($q, $var);
            return $retval[0];
        }
        elseif (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($q, $var, "isLiteral")) {
            $literalValue = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $var);
            if (is_float($literalValue)) {
                return new Erfurt_Owl_Structured_Literal_FloatingPointLiteral($literalValue);
            }
            elseif (is_int($literalValue)) {
                return new Erfurt_Owl_Structured_Literal_IntegerLiteral($literalValue);
            }
            elseif (is_numeric($literalValue)) {
                return new Erfurt_Owl_Structured_Literal_DecimalLiteral($literalValue);
            }
            elseif (is_string($literalValue)) {
                // TODO add support for typed literals and language tags
                return new Erfurt_Owl_Structured_Literal_StringLiteral($literalValue);
            }
        }
        else {
            $retval = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $var);
            return $retval ? new Erfurt_Owl_Structured_Iri($retval) : false;
        }
    }
}

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

        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($q, $variable, "isBlank")) {
            if (($offset = Erfurt_Owl_Structured_Util_SparqlStoreHelper::count($q))>1) {
                // add offset to filter out the first element
                // not implemented yet. proceed with the first element
                // }
                var_dump("not implemented yet");
            }
            elseif ($offset == 1) {
                $p = new Erfurt_Sparql_Query2_IriRef(RDF_TYPE);
                $o = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
                $triple = new Erfurt_Sparql_Query2_Triple($variable, $p, $o);
                $q->addElement($triple);
                $actionType = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $o);
                switch ($actionType) {
                case OWL_CLASS:
                    $structured->addElement($this->getConnectives($q, $variable));
                    break;
                case OWL_RESTRICTION:
                    $structured->addElement($this->getRestriction($q, $o));
                    break;
                case RDFS_DATATYPE:
                    $structured->addElement($this->getConnectives($q, $variable, true));
                    break;
                default:
                    throw new Exception("not implemented yet");
                    break;
                }
            }
        } else {
            // it is a class expression axiom, or done?
            $structured = $this->getIri($q, $variable);
        }
        return $structured;
    }

    private function getIri(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $variable)
    {
        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBuiltinFunction($q, $variable, "isIri")) {
            return new Erfurt_Owl_Structured_Iri(Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $variable));
        } else {
            throw new Exception("$variable is not an Iri");
        }
    }

    private function getRestriction(Erfurt_Sparql_Query2 $q, Erfurt_Sparql_Query2_Var $variable)
    {
        $retval = null;
        $restrictionVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $onPropertyVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $classVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $valueVar = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
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
        // $myQuery->addProjectionVar($restrictionVar);
        // $retval = self::fetch($myQuery);

        $optionalOnClass = new Erfurt_Sparql_Query2_OptionalGraphPattern();
        $optionalOnClass->addElement(new Erfurt_Sparql_Query2_Triple($variable, $onClass, $classVar));
        $myQuery->addElement($optionalOnClass);
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
        $restrictionProperty = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($myQuery, $onPropertyVar);
        $nni =                 Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($myQuery, $valueVar);
        $onClass =             Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($myQuery, $classVar);

        switch ($restrictionType) {
        case OWL_QUALIFIEDCARDINALITY:
            $retval = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectExactCardinality(
                new Erfurt_Owl_Structured_Iri($restrictionProperty), $nni, $onClass);
            break;
        case OWL_ALLVALUESFROM:
            $retval = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectAllValuesFrom(new Erfurt_Owl_Structured_Iri($restrictionProperty), $onClass);
            break;
        default:
            // code...
            break;
        }
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
            echo "Value is bank!!! Needs more work!";
            // return recursively created structured object
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
            return new Erfurt_Owl_Structured_Iri(Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($q, $var));
        }
    }
}

<?php

class Erfurt_Owl_Structured_Util_SparqlHelper {

    private static $i = 0;
    const VAR_ID = "o";
    private $q;
    private $lastVar;

    public function getLastVar()
    {
        return $this->lastVar;
    }

    public function __construct(array $from, $uri)
    {
        $this->q = new Erfurt_Sparql_Query2();
        foreach($from as $from1) {
            $this->q->addFrom(new Erfurt_Sparql_Query2_IriRef($from1));
        }
        $v1 = new Erfurt_Sparql_Query2_Var(self::VAR_ID . self::$i++);
        $this->lastVar = $v1;
        $firstTriple = Erfurt_Owl_Structured_Util_SparqlHelper::createTriple(
                           new Erfurt_Sparql_Query2_IriRef($uri),
                           new Erfurt_Sparql_Query2_IriRef(RDFS_SUBCLASSOF),
                           $v1);
        $this->q->addElement($firstTriple);
        // var_dump((string)$this->q);
        // var_dump(Erfurt_Owl_Structured_Util_SparqlStoreHelper::fetch($this->q));
    }

    /**
     * recursive function
     * current limitations: multiple values in subclass not supported
     */
    public function getStructuredOwl($variable=null)
    {
        if (!$variable) $variable = $this->lastVar;
        // $triple = self::createTriple($variable, self::VAR_ID . self::$i++, self::VAR_ID . self::$i++);
        // $this->q->addElement($triple);

        // $this->q->getOrder()->add($variable);
        if (($offset = Erfurt_Owl_Structured_Util_SparqlStoreHelper::count($this->q))>1) {
            // fork with different offset and limit + orderby
            // for ($i = 0; $i < $offset; $i++) {
            // $this->q->setLimit(1);
            // $this->q->setOffset($offset);
            // var_dump((string)$this->q);
            // }
        }

        // var_dump(Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBlank($this->q, $variable));

        if (Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBlank($this->q, $variable)) {
            // self::checkClassExpression($this->q, $variable);
            // check action (restriction/connective/list)
            // call the appropriate function
            // chech blanks...


            return $this->getRestriction($variable);
            // call recursive
        } else {
            // it is a class expression axiom, or done?
            $value = $this->getIri($variable);
            // var_dump($value);
            // $retval = new Erfurt_Owl_Structured_ClassAxiom_SubClassOf(new Erfurt_Owl_Structured_Iri($value));
            // add variable value to structured owl object
            // return it to caller
            return $value;
        }
    }

    private function getIri($variable)
    {
        return new Erfurt_Owl_Structured_Iri(Erfurt_Owl_Structured_Util_SparqlStoreHelper::getVarValue($this->q, $variable));
//        $filter = new Erfurt_Sparql_Query2_Filter(new Erfurt_Sparql_Query2_isIri($variable));
//        $myQuery = clone $this->q;
//        $myQuery->addElement($filter);
//        $myQuery->addProjectionVar($variable);
//        $retval = Erfurt_Owl_Structured_Util_SparqlStoreHelper::getReturnValue($myQuery);
//        return new Erfurt_Owl_Structured_Iri($retval);
    }

    public static function generateQuery(array $from, $uri) {
        $query = new Erfurt_Sparql_Query2();
        if(is_array($from)) {
            foreach($from as $from1) {
                $query->addFrom(new Erfurt_Sparql_Query2_IriRef($from1));
            }
        }
        $var = new Erfurt_Sparql_Query2_Var(self::VAR_ID, self::$i++);
        $firstTriple = self::createTriple(
                           new Erfurt_Sparql_Query2_IriRef($uri),
                           new Erfurt_Sparql_Query2_IriRef(self::RDFS_NS . "subClassOf"),
                           $var);
        $query->addElement($firstTriple);

        $isBlank = Erfurt_Owl_Structured_Util_SparqlStoreHelper::checkBlank($this->q, $var);
        if ($isBlank) {
            self::findSubClass($var);
            var_dump("more to come. the var is a blank node!");
        }
        return $query;
    }

    public static function findSubClass($var)
    {
        // $variable = new Erfurt_Sparql_Query2_Var($var);
        $query->addElement(
            self::createTriple($variable,
                               new Erfurt_Sparql_Query2_IriRef(self::RDF_TYPE),
                               "x")
        );
        $myQuery = clone $query;
        $myQuery->setQueryType('SELECT');
        $myQuery->addProjectionVar(new Erfurt_Sparql_Query2_Var("x"));
        $retval = self::fetch($myQuery);
        // var_dump((string)$myQuery);
        // var_dump($retval);
        $o = self::getReturnValue($retval);
        switch ($o) {
        case self::OWL_RESTRICTION:
            self::getRestriction($query, $variable);
            break;

        case self::OWL_CLASS:
            self::getConnectives($query, $variable);
            break;
        default:
            // code...
            break;
        }
    }

    private function getRestriction($variable)
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

        $triple1 = self::createTriple($variable, $rdfType, new Erfurt_Sparql_Query2_IriRef(OWL_RESTRICTION));
        $triple2 = self::createTriple($variable, $onProperty, $onPropertyVar);
        $triple3 = self::createTriple($variable, $restrictionVar, $valueVar);

        $this->q->addElements(array($triple1, $triple2, $triple3));
        $myQuery = clone $this->q;
        $myQuery->setQueryType('SELECT');
        // $myQuery->addProjectionVar($restrictionVar);
        // $retval = self::fetch($myQuery);

        $optionalOnClass = new Erfurt_Sparql_Query2_OptionalGraphPattern();
        $optionalOnClass->addElement(self::createTriple($variable, $onClass, $classVar));
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

        default:
            // code...
            break;
        }
        return $retval;
    }

    private static function getConnectives(Erfurt_Sparql_Query2 $query, $variable)
    {
        $rdfType = new Erfurt_Sparql_Query2_IriRef(self::RDF_TYPE);
        $connectiveVar = new Erfurt_Sparql_Query2_Var('connective');
        $valueVar = new Erfurt_Sparql_Query2_Var('valueVar');
        $triple1 = self::createTriple($variable, $connectiveVar, $valueVar);

        $filter1 = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_UnaryExpressionNot(
                new Erfurt_Sparql_Query2_sameTerm(
                    $connectiveVar, $rdfType
                )));
        $myQuery = clone $query;
        $myQuery->addElement($filter1);
        $myQuery->addElement($triple1);
        // var_dump((string)$myQuery);

        $retval = self::fetch($myQuery);
        if (self::checkBlank($myQuery, $valueVar)) {
            self::completeQuery($myQuery, $valueVar);
        }

        var_dump($retval);

    }

    public static function createTriple($s, $p, $o)
    {
        $s1 = ($s instanceof Erfurt_Sparql_Query2_ElementHelper) ? $s : new Erfurt_Sparql_Query2_Var($s);
        $p1 = ($p instanceof Erfurt_Sparql_Query2_ElementHelper) ? $p : new Erfurt_Sparql_Query2_Var($p);
        $o1 = ($o instanceof Erfurt_Sparql_Query2_ElementHelper) ? $o : new Erfurt_Sparql_Query2_Var($o);
        return new Erfurt_Sparql_Query2_Triple($s1, $p1, $o1);
    }

    // TODO rewrite!
    private function generateQueryForList(Erfurt_Sparql_Query2 $query, $variable)
    {
        $first = new Erfurt_Sparql_Query2_IriRef(self::RDF_FIRST);
        $rest = new Erfurt_Sparql_Query2_IriRef(self::RDF_REST);
        $nil = new Erfurt_Sparql_Query2_IriRef(self::RDF_NIL);
        $isNil = false;
        $i = 0;
        $varName = "o";
        $currentVar = $variable;

        while (!$isNil) {
            // $currentVar = $varName . $i++;
            $tripleFirst = self::createTriple($currentVar, $first, $varName . $i++);
            $tripleRest = self::createTriple($currentVar, $rest, $varName . $i++);
            $query->addElements(array($tripleFirst, $tripleRest));
            $isNil=true;
        }
        var_dump((string)$query);
        return $query;
    }
}

<?php

/**
 * represents a user-defined function call
 * @package    Erfurt_Sparql_Query2
 */
class Erfurt_Sparql_Query2_Function extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IriRefOrFunction{
    protected $iri;
    protected $args = array();

    /**
     *
     * @param Erfurt_Sparql_Query2_IriRef|string $iri the iri of the function
     * @param array $args array of arguments (Erfurt_Sparql_Query2_Expression) of the function.
     */
    public function __construct($iri, $args = array()) {
        if (is_string($iri)) {
            $iri = new Erfurt_Sparql_Query2_IriRef($iri);
        }

        if (!($iri instanceof Erfurt_Sparql_Query2_IriRef)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Function::__construct must be an instance of Erfurt_Sparql_Query2_IriRef or string (will be converted to IriRef), instance of '.typeHelper($iri).' given');
        }

        $this->iri = $iri;
        if ($args instanceof Erfurt_Sparql_Query2_Expression) {
            //only one given - pack into array
            $args = array($args);
        }


        if (!is_array($args)) {
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($args).' given');
        } else {
            foreach ($args as $arg) {
                if (!($arg instanceof Erfurt_Sparql_Query2_Expression)) {
                    throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($arg).' given');
                } else {
                    $this->args[] = $arg;
                }
            }
        }
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return $this->iri->getSparql().'('.implode(', ', $this->args).')';
    }

}

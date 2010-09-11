<?php
/**
 * Generates SQL from Sparql FILTER parts
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 *
 * @package erfurt
 * @subpackage sparql
 */
class Erfurt_Sparql_EngineDb_FilterGenerator
{
    /**
    *   SQL Generator
    *   @var SparqlEngineDb_SqlGenerator
    */
    protected $sg = null;

    /**
    *   If the filter is in an optional statement
    *   @var boolean
    */
    protected $bOptional    = false;

    /**
    *   Number of parameters for the functions supported.
    *   First value is minimum, second is maximum.
    *   @var array
    */
    protected static $arFuncParamNumbers = array(
        'bound'         => array(1, 1),
        'datatype'      => array(1, 1),
        'isblank'       => array(1, 1),
        'isiri'         => array(1, 1),
        'isliteral'     => array(1, 1),
        'isuri'         => array(1, 1),
        'lang'          => array(1, 1),
        'langmatches'   => array(2, 2),
        'regex'         => array(2, 3),
        'sameterm'      => array(2, 2),
        'str'           => array(1, 1),
        'xsd:datetime'  => array(1, 1),
    );

    /**
    *   List of operators and their counterpart if operands are switched.
    *   (a > b) => (b < a)
    *   @var array
    */
    protected static $arOperatorSwitches = array(
        '>'     => '<',
        '<'     => '>',
        '>='    => '<=',
        '<='    => '>=',
    );

    protected static $arDumbOperators = array(
        '&&', '||'
    );

    protected static $typeXsdBoolean  = 'http://www.w3.org/2001/XMLSchema#boolean';
    protected static $typeXsdDateTime = 'http://www.w3.org/2001/XMLSchema#dateTime';
    protected static $typeXsdDouble   = 'http://www.w3.org/2001/XMLSchema#double';
    protected static $typeXsdFloat    = 'http://www.w3.org/2001/XMLSchema#float';
    protected static $typeXsdInteger  = 'http://www.w3.org/2001/XMLSchema#integer';
    protected static $typeXsdString   = 'http://www.w3.org/2001/XMLSchema#string';
    protected static $typeVariable    = 'variable';
}

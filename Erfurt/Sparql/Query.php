<?php
/**
 * This Class Query represents a SPARQL query.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: Query.php 3021 2009-05-04 13:45:43Z pfrischmuth $
 */
class Erfurt_Sparql_Query 
{    
    // ------------------------------------------------------------------------
    // --- Public properties --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Blanknode counter.
     * How many blank nodes are in $resultPart
     *
     * @var int
     */
    public $bnodeCounter = 0;
    
    /**
     * GraphPattern counter.
     * How many GraphPattern are in $resultPart
     *
     * @var int
     */
    public $graphPatternCounter = 0;
    
    /**
     *   Datatype of variables. NULL if the variable has no
     *   data type (e.g. ^^xsd::integer) set.
     *   $varname => $datatype
     *   @var array
     */
    public $varDatatypes = array();

    /**
     *   Language of variables. NULL if the variable has no
     *   language tag (e.g. @en) set.
     *   $varname => $language tag
     *   @var array
     */
    public $varLanguages = array();
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * The BASE part of the SPARQL query.
     *
     * @var string
     */
    protected $base = null;
    
    /**
     * If the query type is CONSTRUCT this variable contains the
     * CONSTRUCT graph pattern.
     *
     * @var string
     */
    protected $constructPattern = null;
    
    /**
     * Contains the FROM part of the SPARQL query.
     *
     * @var array
     */
    protected $fromPart = array();
    
    /**
     * Contains the FROM NAMED part of the SPARQL query.
     *
     * @var array
     */
    protected $fromNamedPart = array();
    
    /**
     * Array that contains used prefixes and namespaces.
     * Key is the prefix, value the namespace.
     *
     * @example
     * array(8) {
     *  ["rdf"] => string(43) "http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     *  ["rdfs"]=> string(37) "http://www.w3.org/2000/01/rdf-schema#"
     * }
     *
     * @var array
     */
    protected $prefixes = array();

    /**
     * Original SPARQL query string
     * @var string
     */
    protected $queryString = null;

    /**
     * What form/type of result should be returned.
     *
     * One of:
     * - "ask"
     * - "count"
     * - "construct"
     * - "describe"
     * - "select"
     * - "select distinct"
     *
     * @var string
     * @see http://www.w3.org/TR/rdf-sparql-query/#QueryForms
     */
    protected $resultForm = null;

    /**
     * Contains the result part of the SPARQL query.
     * Array of GraphPattern
     *
     * @var array
     */
    protected $resultPart = array();

    /**
     * Array of result variables that shall be returned.
     * E.g. "?name", "?mbox"
     *
     * @var array
     */
    protected $resultVars = array();

    /**
     * Optional solution modifier of the query.
     * Array with three keys: "order by", "limit", "offset"
     * If they are not set, their value is null
     *
     * "order by" can be an array with subarrays, each of those
     * subarrays having two keys: "val" and "type".
     * 
     * "val" determines the variable ("?mbox"), 
     * "type" is "asc" or "desc"
     *
     * @var array
     */
    protected $solutionModifier = array();

    /**
     * List of all vars used in the query.
     * Key is the variable (e.g. "?x"), value is boolean true
     *
     * @var array
     */
    protected $usedVars = array();

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->resultForm = null;
        $this->solutionModifier['order by'] = null;
        $this->solutionModifier['limit']    = null;
        $this->solutionModifier['offset']   = null;
        $this->bnodeCounter = 0;
        $this->graphPatternCounter = 0;
    }
    
    public function __toString() 
    {    
        return $this->queryString;
    }
    
    // ------------------------------------------------------------------------
    // --- Public static methods ----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     *   Returns the language of a variable if the tag is set (e.g. @en)
     *   Returns null if no language is set.
     *
     *   @param string Sparql variable name
     *   @return mixed null or language tag
     */
    public static function getLanguageTag($var)
    {
        if (is_string($var)) {
            $nAt = strpos($var, '@');
            if ($nAt === false) {
                return null;
            }

            //in case @ and ^^ are combined
            $nHatHat = strpos($var, '^^', $nAt + 1);
            if ($nHatHat === false) {
                $tag = substr($var, $nAt + 1);
            } else {
                $tag = substr($var, $nAt + 1, $nHatHat - $nAt - 1);
            }
            return $tag;
        } else {
            return null;
        }
        
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
    * Adds a construct graph pattern to the query.
    *
    * @param  Erfurt_Sparql_GraphPattern $pattern
    */
    public function addConstructGraphPattern($pattern)
    {
        $this->constructPattern = $pattern;
    }

    /**
    * Adds a graphuri to the from part.
    *
    * @param  String $graphURI
    * @return void
    */
    public function addFrom($graphURI){
        $this->fromPart[] = $graphURI;
    }

    /**
    * Adds a graphuri to the from named part.
    *
    * @param  String $graphURI
    * @return void
    */
    public function addFromNamed($graphURI){
        $this->fromNamedPart[] = $graphURI;
    }

    /**
     * Adds a graph pattern to the result part.
     *
     * @param  Erfurt_Sparql_GraphPattern $pattern
     */
    public function addGraphPattern($pattern)
    {
        $pattern->setId($this->graphPatternCounter++);
        $this->resultPart[] = $pattern;
    }

    /**
     * Adds a prefix to the list of prefixes.
     *
     * @param  string $prefix
     * @param  string $label
     */
    public function addPrefix($prefix, $label)
    {
        $this->prefixes[$prefix] = $label;
    }

    /**
     * Adds a variable to the list of result variables.
     *
     * @param  string $var
     */
    public function addResultVar($var)
    {
        $this->resultVars[] = $var;
        
        $datatype = $this->getDatatype($var);
        $id = $var->getId();
        $var->setDatatype($datatype);

        $this->varLanguages[$id] = self::getLanguageTag($var);
        $this->varDatatypes[$id] = $datatype;
    }
    
    public function setResultVars($vars)
    {
        $this->resultVars = array();
        foreach ($vars as $var) {
            $this->addResultVar($var);
        }
    }
    
    /**
     * Adds a new variable to the variable list.
     *
     * @param  string $var
     */
    public function addUsedVar($var)
    {
        $this->usedVars[$var] = true;
    }
    
    /**
     * Returns a list with all used variables.
     *
     * @return array
     */
    public function getAllVars()
    {
        return array_keys($this->usedVars);
    }

    /**
     * Returns the BASE part of the query.
     *
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }
    
    /**
     * Returns an unused Bnode label.
     *
     * @return string
     */
    public function getBlanknodeLabel()
    {
        return ('_:bN' . $this->bnodeCounter++);
    }
    
    /**
     * Returns the construct graph pattern of the query if there is one.
     *
     * @return Erfurt_Sparql_GraphPattern
     */
    public function getConstructPattern()
    {
        return $this->constructPattern;
    }

    /**
     *   Returns a list of variables used in the construct patterns.
     *
     *   @return array Array of variable names, unique.
     */
    public function getConstructPatternVariables()
    {
        $arVars = array();
        if ($this->constructPattern) {
            $arVars = $this->constructPattern->getVariables();
        }

        return array_unique($arVars);
    }
    
    /**
     *   Returns the datatype of a variable if it is set.
     *
     *   @param string Sparql variable name
     *   @return mixed null or datatype
     */
    public function getDatatype($var)
    {
        if (is_string($var)) {
            $nHatHat = strpos($var, '^^');
            if ($nHatHat === false) {
                return null;
            }

            $nAt = strpos($var, '@', $nHatHat + 2);
            if ($nAt === false) {
                $type = substr($var, $nHatHat + 2);
            } else {
                $type = substr($var, $nHatHat + 2, $nAt - $nHatHat - 2);
            }

            $fullUri = $this->getFullUri($type);
            if ($fullUri === false) {
                $fullUri = $type;
                if ($fullUri[0] == '<' && substr($fullUri, -1) == '>') {
                    $fullUri = substr($fullUri, 1, -1);
                }
            }

            return $fullUri;
        } else {
            return null;
        }
        
    }
    
    /**
     * Returns the FROM clause of the query.
     *
     * @return string
     */
    public function getFromPart()
    {
        return $this->fromPart;
    }
    
    /**
     * Returns the FROM NAMED clause of the query.
     *
     * @return array
     */
    public function getFromNamedPart()
    {
        return $this->fromNamedPart;
    }
    
    /**
     * Gets the full URI of a qname token.
     *
     * @param  string $token
     * @return string The complete URI of a given token, false if $token is not
     * a qname or the prefix is not defined.
     */
    public function getFullUri($token)
    {
        $pattern = "/^([^:]*):([^:]*)$/";
        
        if (preg_match($pattern, $token, $hits) > 0) {
            if (isset($this->prefixes{$hits{1}})) {
                return substr($this->base, 1, -1) . $this->prefixes{$hits{1}} . $hits{2};
            }
            if ($hits{1} == '_') {
                return '_' . $hits{2};
            }
        }

        return false;
    }

    /**
     * Generates a new GraphPattern and adds it to the list of graph pattern.
     * If it is a CONSTRUCT graph pattern $constr has to be set to true, false if not.
     *
     * @param  boolean $constr
     * @return Erfurt_Sparql_GraphPattern
     */
    public function getNewPattern($constr = false)
    {
        require_once 'Erfurt/Sparql/GraphPattern.php';
        $pattern = new Erfurt_Sparql_GraphPattern();
        
        if ($constr === true) {
            $this->addConstructGraphPattern($pattern);
        } else {
            $this->addGraphPattern($pattern);
        }
        
        return $pattern;
    }

    /**
     * Returns the prefix map of the query.
     *
     * @return array
     */
    public function getPrefixes()
    {
        return $this->prefixes;
    }
    
    /**
     * Returns the orignal query string.
     *
     * @return string SPARQL query string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }
    
    /**
     * Returns the type the result shall have.
     * E.g. "select", "select distinct", "ask", ...
     *
     * @see $resultForm
     *
     * @return string
     */
    public function getResultForm()
    {
        return $this->resultForm;
    }
    
    /**
     * Returns a list containing the graph patterns of the query.
     *
     * @return array
     */
    public function getResultPart()
    {
        return $this->resultPart;
    }
    
    /**
     * Returns a specific result var or false, if the query does not contain that
     * variable in the result variables.
     *
     * @return array
     */
    public function getResultVar($strName) 
    {
        foreach ($this->resultVars as $var) {
            if ($var->getVariable() === $strName) {
                return $var;
            }
        }
        
        return false;
    }

    /**
     * Returns a list containing the result vars.
     *
     * @return array
     */
    public function getResultVars()
    {
        return $this->resultVars;
    }
    
    /**
     * Gets the solution modifiers of the query.
     * $solutionModifier['order by'] = value
     *                  ['limit']    = vlaue
     *                  ['offset']   = value
     *
     *
     * @return array
     */
    public function getSolutionModifier()
    {
        return $this->solutionModifier;
    }

    /**
     *   Checks if the query is complete (so that querying is possible).
     *
     *   @return boolean true if the query is complete
     */
    public function isComplete()
    {
        if ($this->resultForm === null) {
            return false;
        }
        
        return true;
    }

    /**
     * Sets the base part.
     *
     * @param string $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }
    
    public function setFromPart(array $from) 
    {    
        $this->fromPart = $from;
    }
    
    public function setFromNamedPart(array $fromNamed)
    {
        $this->fromNamedPart = $fromNamed;
    }

    /**
     * Sets the orignal query string
     *
     * @param string $queryString SPARQL query string
     */
    public function setQueryString($queryString) 
    {
        $this->queryString = $queryString;
    }

    /**
     * Sets the result form.
     *
     * @param  string $form
     */
    public function setResultForm($form)
    {
        $this->resultForm = strtolower($form);
    }

    /**
     * Sets the result part.
     *
     * @param  array Array of graph patterns
     */
    public function setResultPart($resultPart) 
    {
        $this->resultPart = $resultPart;
    }
    
    /**
     * Sets a solution modifier.
     *
     * @param string $name
     * @param string $value
     */
    public function setSolutionModifier($name, $value)
    {
        $this->solutionModifier[$name] = $value;
    }
}

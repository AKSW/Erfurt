<?php
/**
 * A graph pattern which consists of triple patterns, optional
 * or union graph patterns and filters.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: GraphPattern.php 3021 2009-05-04 13:45:43Z pfrischmuth $
 */
class Erfurt_Sparql_GraphPattern 
{
    /**
     * Graphname. 0 if its in the default graph.
     */
    protected $graphname = null;

    /**
     * Array of QueryTriple objects
     *
     * @var array
     */
    protected $triplePatterns = array();

    /**
     * A List of Constraint objects
     *
     * @var array
     */
    protected $constraints = array();

    /**
     * @var int Pointer to optional pattern.
     */
    protected $optional = null;

    /**
     * @var int Pointer to union pattern.
     */
    protected $union = null;

    /**
     * ID of the pattern in the pattern list that
     * this pattern is subpattern of.
     *
     * @var int
     */
    protected $subpatternOf = null;

    /**
     * @var boolean TRUE if the pattern is open- FALSE if closed.
     */
    public $open = false;

    /**
     * @var boolean TRUE if the GraphPattern is a construct pattern.
     */
    public $isConstructPattern = false;

    /**
     * @var int The GraphPatterns id.
     */
    public $patternId = null;


    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->open               = true;
        $this->isConstructPattern = false;
        $this->constraints        = array();
        $this->triplePatterns     = array();
    }

    /**
     * Returns the graphname.
     *
     * @return string
     */
    public function getGraphname()
    {
        return $this->graphname;
    }

    /**
     * Returns the triple pattern of the graph pattern.
     *
     * @return array
     */
    public function getTriplePatterns()
    {
        return $this->triplePatterns;
    }

    /**
     * Returns a constraint if there is one false if not.
     *
     * @return Erfurt_Sparql_Constraint
     */
    public function getConstraints() 
    {
        return $this->constraints;
    }

    /**
     * Returns a pointer to an optional graph pattern.
     *
     * @return int
     */
    public function getOptional() 
    {
        return $this->optional;
    }

    /**
     * Returns a pointer to the parent pattern this pattern
     * is subpattern of.
     *
     * @return int
     */
    public function getSubpatternOf() 
    {
        return $this->subpatternOf;
    }

    /**
     * Returns a pointer to a union graph pattern.
     *
     * @return integer
     */
    public function getUnion() 
    {
        return $this->union;
    }

    /**
     * Sets the graphname.
     *
     * @param  string $name
     */
    public function setGraphname($name) 
    {
        $this->graphname = $name;
    }

    /**
     * Adds List of QueryTriples to the GraphPattern.
     *
     * @param  array $trpP
     */
    public function addTriplePatterns($trpP) 
    {
        $this->triplePatterns = array_merge($this->triplePatterns, $trpP);
    }
    
    public function addTriplePattern(Erfurt_Sparql_QueryTriple $pattern)
    {
        $this->triplePatterns[] = $pattern;
    }

    /**
     * Sets the List of QueryTriples to the GraphPattern.
     *
     * @param  array $trpP
     */
    public function setTriplePatterns($trpP) 
    {
        $this->triplePatterns = $trpP;
    }

    /**
     * Adds a single Constraint to the GraphPattern.
     *
     * @param  Constraint $cons
     */
    public function addConstraint($cons) 
    {
        $this->constraints[] = $cons;
    }

    /**
     * Adds an array of Constraint objects to the GraphPattern.
     *
     * @param  array $cons
     */
    public function addConstraints($cons) 
    {
        $this->constraints = array_merge($this->constraints, $cons);
    }
    
    public function setConstraints($cons)
    {
        $this->constraints = $cons;
    }

    /**
     * Adds a pointer to an optional graphPattern.
     *
     * @param int $patternId
     */
    public function setOptional($patternId) 
    {
        $this->optional = $patternId;
    }

    /**
     * Adds a pointer to a union graphPattern.
     *
     * @param int $patternId
     */
    public function setUnion($patternId) 
    {
        $this->union = $patternId;
    }

    /**
     * Adds a pointer to a pattern that
     * this one is subpattern of
     *
     * @param integer $patternId
     */
    public function setSubpatternOf($patternId) 
    {
        $this->subpatternOf = $patternId;
    }

    /**
     * Sets the GraphPatterns Id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->patternId = $id;
    }

    /**
     * Returns the GraphPatterns id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->patternId;
    }

    /**
     *   Returns an array of all variables used in this
     *   graph pattern.
     *   All variables are listed only once (unique).
     *
     *   @return array Array of variable names.
     */
    public function getVariables()
    {
        $arVars = array();

        foreach ($this->triplePatterns as $pattern) {
            $arVars = array_merge($arVars, $pattern->getVariables());
        }

        return array_unique($arVars);
    }

    /**
     *   Checks if the graph pattern is empty (contains no
     *   usable data).
     *   Occurs when using "{}" without pre- or suffixes
     *   WHERE
     *   {
     *      { ?person rdf:type foaf:Person } .
     *   }
     *
     *   @return boolean True if the pattern is empty.
     */
    public function isEmpty()
    {
        return  (
                    (count($this->triplePatterns) === 0) && 
                    (count($this->constraints) === 0) && 
                    ($this->getGraphname() === null)
                );
    }


    /**
     *   When cloning, we need to clone some subobjects, too
     */
    public function __clone()
    {
        if (count($this->triplePatterns) > 0) {
            foreach ($this->triplePatterns as $nId => $pattern) {
                $this->triplePatterns[$nId] = clone $this->triplePatterns[$nId];
            }
        }
        if (count($this->constraints) > 0) {
            foreach ($this->constraints as $nId => $constraint) {
                $this->constraints[$nId] = clone $this->constraints[$nId];
            }
        }
    }
}

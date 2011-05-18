<?php
/**
 * Represents a query triple with subject, predicate and object.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: QueryTriple.php 2899 2009-04-20 13:32:26Z sebastian.dietzold $
 */
class Erfurt_Sparql_QueryTriple
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * The QueryTriples Subject. Can be a BlankNode or Resource, string in
     * case of a variable
     *
     * @var Node/string
     */
    protected $_subject;

    /**
     * The QueryTriples Predicate. Normally only a Resource, string in case of a variable
     * 
     *@var Node/string
     */
    protected $_predicate;

    /**
     * The QueryTriples Object. Can be BlankNode, Resource or Literal, string in case of a variable.
     *
     * @var Node/string
     */
    protected $_object;

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    public function __clone()
    {
        if (is_object($this->_subject)) {
		    $this->_subject = clone $this->_subject;
		}
		if (is_object($this->_predicate)) {
		    $this->_predicate = clone $this->_predicate;
		}
		if (is_object($this->_object)) {
		    $this->_object = clone $this->_object;
		}
    }

    /**
     * Constructor
     *
     * @param Erfurt_Rdf_Resource/string $subject Subject
     * @param Erfurt_Rdf_Resource/string $predicate Predicate
     * @param Erfurt_Rdf_Node/string $object Object
     */
    public function __construct($subject, $predicate, $object)
    {
        $this->_subject   = $subject;
        $this->_predicate = $predicate;
        $this->_object    = $object;
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Returns the Triples Object.
     *
     * @return Erfurt_Rdf_Node/string
     */
    public function getObject()
    {
        return $this->_object;
    }

    /**
     * Returns the Triples Predicate.
     *
     * @return Erfurt_Rdf_Resource/string
     */
    public function getPredicate()
    {
        return $this->_predicate;
    }
    
    /**
     * Returns the Triples Subject.
     *
     * @return Erfurt_Rdf_Resource/string
     */
    public function getSubject()
    {
        return $this->_subject;
    }
    
    /**
     *   Returns an array of all variables in this triple.
     *
     *   @return array Array of variable names.
     */
    public function getVariables()
    {
        $arVars = array();
		
		require_once 'Erfurt/Sparql/Variable.php';
		if (Erfurt_Sparql_Variable::isVariable($this->_subject)) {
		    $arVars[] = $this->_subject;
		}
		if (Erfurt_Sparql_Variable::isVariable($this->_predicate)) {
		    $arVars[] = $this->_predicate;
		}
		if (Erfurt_Sparql_Variable::isVariable($this->_object)) {
		    $arVars[] = $this->_object;
		}
		
        return $arVars;
    }
}

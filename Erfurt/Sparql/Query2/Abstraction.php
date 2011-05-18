<?php
require_once dirname(__FILE__)."/../Query2.php";
require_once "Abstraction/ClassNode.php";
require_once "Abstraction/RDFSClass.php";
require_once "Abstraction/Link.php";
require_once "Abstraction/Utils.php";

//under construction
/**
 * Erfurt_Sparql Query - Abstraction.
 * 
 * an Abstraction for Sparql-Queries
 * 
 * @see            {@link http://code.google.com/p/Erfurt_Sparql/wiki/QueryObject Idea}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Abstraction
{
    protected $query;
    protected $startNode;
    
    /**
     * @param Erfurt_Sparql_Query2_IriRef|string|null $class 
     * @param bool $withChilds wether to include subclasses of $class
     * @param string|null $varName the var-name to be used for instances of this class
     * @param string $member_predicate the predicate that stands between the class und its instances (mostly rdf:type) 
     */
    public function __construct($class = null, $withChilds = true, $varName = null, $member_predicate = EF_RDF_TYPE) {
        $this->query = new Erfurt_Sparql_Query2();
        if ($class != null && !($class instanceof Erfurt_Sparql_Query2_IriRef)) {
            if (is_string($class)) {
                $class = new Erfurt_Sparql_Query2_IriRef($class);
            } 
            if (!($class instanceof Erfurt_Sparql_Query2_IriRef))
                 throw new RuntimeException("Argument 3 passed to Erfurt_Sparql_Query2_Abstraction::addNode must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($class)." given");
        }
        
        //add startnode
        $this->startNode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($class, $member_predicate, $this->query, $varName, $withChilds);
    }
    
    
    public function __clone() {
    } 
    
    
    /**
     * redirect method calls to the query object
     * @param string $name
     * @param array $params
     */
    public function __call($name, $params) {
        if ($name != "getWhere" && $name != "addTriple") { //you shall not mess with the abstraction concept
            if (method_exists($this->query, $name)) {
                $ret = call_user_func_array(array($this->query, $name), $params); 
            } elseif (method_exists($this->startNode, $name)) {
                $ret = call_user_func_array(array($this->startNode, $name), $params); 
            } else throw new RuntimeException("Query2_Abstraction: method $name does not exists");
            
            if ($this->query->equals($ret) || $this->startNode->equals($ret))
                return $this; 
            else 
                return $ret;
                
        } else throw new RuntimeException("Query2_Abstraction: method $name not allowed");
    }
    
    /**
     * addNode
     * 
     * add a node to the tree of class-nodes
     * 
     * @param Erfurt_Sparql_Query2_Abstraction_ClassNode $sourceNode where in the tree of nodes should the new node be added
     * @param Erfurt_Sparql_Query2_IriRef|string $LinkPredicate over which predicate you want to link 
     * @param Erfurt_Sparql_Query2_IriRef|string|null $targetClass can be used to link to a subset of all possible
     * @param bool $withChilds wether to include subclasses of $class
     * @param string|null $varName the var-name to be used for instances of this class
     * @param string $member_predicate the predicate that stands between the class und its instances (mostly rdf:type) 
     * @return Erfurt_Sparql_Query2_Abstraction_ClassNode the new node
     */
    public function addNode(Erfurt_Sparql_Query2_Abstraction_ClassNode $sourceNode, $LinkPredicate, $targetClass = null, $withChilds = true, $varName = null, $member_predicate = EF_RDF_TYPE) {
        // hack for overloaded functioncalls
        if (!($LinkPredicate instanceof Erfurt_Sparql_Query2_IriRef)) {
            if (is_string($LinkPredicate)) {
                $LinkPredicate = new Erfurt_Sparql_Query2_IriRef($LinkPredicate);
            } else throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_Abstraction::addNode must be an instance of Erfurt_Sparql_Query2_IriRef or string, instance of ".typeHelper($LinkPredicate)." given");
        }
        
            if ($targetClass == null) {
                //TODO: find type of referenced objects
            }
            //add link from source node to new node
            $newnode = new Erfurt_Sparql_Query2_Abstraction_ClassNode($targetClass, $member_predicate, $this->query, $varName, $withChilds);
            $sourceNode->addLink($LinkPredicate, $newnode);
            return $newnode; //for chaining

    }
        
    /**
     * getSparql
     * build a query string
     * @return    string    query
     */
    public function getSparql() {
        return $this->query->getSparql();
    }
    
    public function __toString() {
        return $this->getSparql();
    }
    
    /**
     * getStartNode
     * @return Erfurt_Sparql_Query2_Abstraction_ClassNode the root-node
     */
    public function getStartNode() {
        return $this->startNode;
    }
    
    /**
     * getRealQuery
     * @return Erfurt_Sparql_Query2 the query that is handled inside - but only a clone to prevent external manipulation that wont fit in the scheme
     */
    public function getRealQuery() {
        return clone $this->query;
    }
}
?>

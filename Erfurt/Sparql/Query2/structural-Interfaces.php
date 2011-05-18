<?php
/**
 * Erfurt Sparql Query2 - IF_TriplesSameSubject
 * 
 * interface that is used by Triples and TriplesSameSubject
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_IF_TriplesSameSubject {}

/**
 * Erfurt Sparql Query2 - ObjectList
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
 
interface Erfurt_Sparql_Query2_IF_ObjectList {}
/**
 * Erfurt Sparql Query2 - GraphNode
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_GraphNode extends Erfurt_Sparql_Query2_IF_ObjectList{}

/**
 * Erfurt Sparql Query2 - TriplesNode
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_TriplesNode extends Erfurt_Sparql_Query2_GraphNode{}

/**
 * Erfurt Sparql Query2 - VarOrTerm
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_VarOrTerm extends Erfurt_Sparql_Query2_GraphNode {}

/**
 * Erfurt Sparql Query2 - Verb
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_Verb {}

/**
 * Erfurt Sparql Query2 -VarOrIriRef 
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_VarOrIriRef extends Erfurt_Sparql_Query2_Verb {}

/**
 * Erfurt Sparql Query2 - GraphTerm
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: structural-Interfaces.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_GraphTerm extends Erfurt_Sparql_Query2_VarOrTerm {}

?>

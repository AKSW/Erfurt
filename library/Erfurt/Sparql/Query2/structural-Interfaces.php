<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt Sparql Query2 - IF_TriplesSameSubject
 * 
 * interface that is used by Triples and TriplesSameSubject
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_IF_TriplesSameSubject {}

/**
 * Erfurt Sparql Query2 - ObjectList
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_IF_ObjectList {}

/**
 * Erfurt Sparql Query2 - GraphNode
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_GraphNode extends Erfurt_Sparql_Query2_IF_ObjectList{}

/**
 * Erfurt Sparql Query2 - TriplesNode
 * Represents the TriplesNode Rule
 *
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_TriplesNode extends Erfurt_Sparql_Query2_GraphNode{}

/**
 * Erfurt Sparql Query2 - VarOrTerm
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_VarOrTerm extends Erfurt_Sparql_Query2_GraphNode {}

/**
 * Erfurt Sparql Query2 - Verb
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_Verb {}

/**
 * Erfurt Sparql Query2 -VarOrIriRef 
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_VarOrIriRef extends Erfurt_Sparql_Query2_Verb {}

/**
 * Erfurt Sparql Query2 - GraphTerm
 * 
 * @see {@link http://www.w3.org/TR/rdf-sparql-query/ SPARQL-Grammar}
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Query2_GraphTerm extends Erfurt_Sparql_Query2_VarOrTerm {}

?>

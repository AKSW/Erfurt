<?php
/**
 * Erfurt_Sparql Query - Verb.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
interface Erfurt_Sparql_Query2_IF_TriplesSameSubject {}
interface Erfurt_Sparql_Query2_IF_ObjectList {}
interface Erfurt_Sparql_Query2_GraphNode extends Erfurt_Sparql_Query2_IF_ObjectList{}
interface Erfurt_Sparql_Query2_TriplesNode extends Erfurt_Sparql_Query2_GraphNode{}
interface Erfurt_Sparql_Query2_VarOrTerm extends Erfurt_Sparql_Query2_GraphNode {}
interface Erfurt_Sparql_Query2_Verb {}
interface Erfurt_Sparql_Query2_VarOrIriRef extends Erfurt_Sparql_Query2_Verb {}

interface Erfurt_Sparql_Query2_GraphTerm extends Erfurt_Sparql_Query2_VarOrTerm {}

?>

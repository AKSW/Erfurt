<?php
/*
 * owlapi.php
 * Encoding: ISO-8859-1
 *
 * Copyright (c) 2006 Sören Auer <soeren@auer.cx>
 *
 * This file is part of pOWL - web based ontology editor.
 *
 * pOWL is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * pOWL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pOWL; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * includes required OWL-API files
 * 
 * @package owlapi
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: owlapi.php 629 2006-11-06 18:47:55Z p_frischmuth $
 * @access public
 **/

// try to guess 'RDFSAPI_INCLUDE_DIR' if 'OWLAPI_INCLUDE_DIR' is defined
if(!defined('RDFSAPI_INCLUDE_DIR') && defined('OWLAPI_INCLUDE_DIR'))
	define('RDFSAPI_INCLUDE_DIR',str_replace('owlapi/','rdfsapi/',OWLAPI_INCLUDE_DIR));

// load RDFSAPI
require_once(RDFSAPI_INCLUDE_DIR.'rdfsapi.php');

// Add vocabulary missing in rdfapi-php/api/vocabulary/owl.php
$OWL_equivalentClass=new Resource(OWL_NS."equivalentClass");
$OWL_equivalentProperty=new Resource(OWL_NS."equivalentProperty");
$OWL_Thing=new Resource(OWL_NS."Thing");
$OWL_Nothing=new Resource(OWL_NS."Nothing");
$OWL_AllDifferent=new Resource(OWL_NS."AllDifferent");
$OWL_distinctMembers=new Resource(OWL_NS."distinctMembers");

require_once(OWLAPI_INCLUDE_DIR.'OWLModel.php');
require_once(OWLAPI_INCLUDE_DIR.'OWLClass.php');
require_once(OWLAPI_INCLUDE_DIR.'OWLProperty.php');
require_once(OWLAPI_INCLUDE_DIR.'OWLInstance.php');
?>
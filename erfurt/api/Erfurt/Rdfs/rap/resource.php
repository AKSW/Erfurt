<?php
/**
 * RDFSResource
 * 
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id$
 * @access public
 **/
class RDFSResource extends Erfurt_Rdfs_Resource_Abstract {

#######################################################################################################################
#######################################################################################################################
## 
## methods that have to be overwritten for a specific backend
##	
#######################################################################################################################
#######################################################################################################################

	/**
	 * @see DefaultRDFSResource
	 */
	public function definingModels() {
		
		$sql="SELECT modelID from ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE subject='".$this->model->_dbID($this)."' AND predicate='".$this->model->_dbID('RDF_type')."'";
		return $this->model->dbConn->getCol($sql);
	}

}
?>
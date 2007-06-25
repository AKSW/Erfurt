<?php
/**
 * RDFSResource
 * 
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: resource.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class RDFSResource extends DefaultRDFSResource {

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
		
		$sql="SELECT modelID from statements WHERE subject='".$this->model->_dbID($this)."' AND predicate='".$this->model->_dbID('RDF_type')."'";
		return $this->model->dbConn->getCol($sql);
	}

}
?>
<?php
 /**
 *RDF - Output
 *@param string file name; 
 *@return string with content;
 *
 */ 
	$subname =rtrim($this->displayname2iri(substr($uriResource,0,-4)));
	
	$r = $this -> Erfurt_selectedModel -> resourceF($subname);
	
	$m = $r -> getDefiningModel();
	
	echo $m -> writeRdfToString();			
			
		

?>
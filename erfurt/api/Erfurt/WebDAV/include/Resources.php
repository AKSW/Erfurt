<?php
/**
 *the resource handling of all the webdav-shares
 *generic modell view of resources which show the subject-predicate-object behavior 
 *
*/   	
$this->GetComponents($path);
//subject search
if($this->components[3] != NULL && $this->components[4] == NULL) {
	list($bla,$anfang,$ende) = split("_",$this->components[3]);								
	$query=$this->querystring."SELECT DISTINCT ?resource
	WHERE {?resource ?predicate ?object 
	      }
	ORDER BY ?resource";
	$res = $this -> Erfurt_selectedModel->sparqlQuery($query);
	$res_result = array_slice($res,$anfang,$this->limit);
	}
//predicate search
else if($this->components[4] != NULL && $this->components[5]== NULL) {
			    
	    $subname = $this->displayname2iri($this->components[4]);
	    $subname = "<$subname>";	
	    $query=$this->querystring."SELECT DISTINCT ?y
	    WHERE { $subname ?y ?z
				}
				ORDER BY ?y
				";
		   	 $res_result = $this -> Erfurt_selectedModel->sparqlQuery($query);						  
}
/**Object search
*
*/		
else if($this->components[4] != NULL &&$this->components[5]!= NULL) {
				    
    $subname = $this->displayname2iri($this->components[4]);
    $subname = "<$subname>";	
    $predname = $this->displayname2iri($this->components[5]);
    $predname = "<$predname>";	
    $query.=$this->querystring."SELECT DISTINCT ?z
    WHERE { $subname $predname ?z
	    	}
			ORDER BY ?z														
			";
	 $res_result = $this -> Erfurt_selectedModel->sparqlQuery($query);						  
}
/**if the object is an iri and exist in these model then could a redirct in this directory
*else the object in an Literal then show the String Literaln and do nothing 
*
*/
else if($this->components[4] != NULL && $this->components[5] != NULL && $this->components[6]!= NULL){
   if($this->is_URI($this->components[6])) {
		$subname = $this->displayname2iri($this->components[6]);
		//Suche das bergebene Objekt im Baum als Subjekt, wenn es gefunden wird, dann stelle den Pfad darauf ein
		$SName= "<$subname>";									
		$path = "resources".$this->components[6]."/";							
		//echo "DER neue".$this->path;
		$query.=$this->querystring."SELECT DISTINCT ?y 
			WHERE {
			<$subname> ?y ?z
			}";
			$res_result = $this -> Erfurt_selectedModel->sparqlQuery($query);									
	}								
	
}
else {
	$querys="SELECT DISTINCT ?x
	WHERE {?x ?y ?z 
	      }
	ORDER BY ?x";
	$res = $this -> Erfurt_selectedModel->sparqlQuery($querys);
	for($i=0;$i < count($res);$i = $i+$this->limit){
		$anfang = $i;
		$ende = $i+$this->limit;
		$pfad=$path."R_".$anfang."_".$ende."/";
		$this->Ausgabe_formal("Pfad",$pfad,$files,"Resource");
	}
}
//Ausgabe der res_result
if(is_array($res_result)) {
	if($res_result=="NULL") $files["files"][] = $this->fileinfo("keine weiteren Objekte ",$mime); 
   	else if(is_array($res_result)){	
		foreach($res_result as $O_Array => $O_Value){
		   	foreach($O_Value as $Ob =>$o_wert){
 				$wert = $o_wert->getLabel();
 				//expizite Darstellung von BlankNodes
   				if(is_a($o_wert,"BlankNode")) {
   					$mime ="BlankNode";   						
   		   			$wert="_:".$wert;
				}
   				else if(is_a($o_wert,"Resource")) {
   	   				$mime ="Resource";   						
   		   			$wert=$this->iri2displayname($wert);
   				}
   				//Literale werden als Literal_1 			
   				else if(is_a( $o_wert,'Literal')){
					$wert = $o_wert->getLabel();			    		
		    			$mime ="Literal";
		    			$i++;
					//if they first call these function else they didnot use these 
	   	 			if($literalname=="") {
						$wert =$this->Literal_function($wert,$i);
	   	 			}
					// An Name Literaln is given
				}
			  	$wert =$path.$wert;	
	   			//Ausgabe der konfigurierten Dateien Resourcedirectory Resource N3 und Resource rdf
	  			if($this->components[4] == NULL) {			    		
	    			if($this->output['resource']['showResourceDir']){
						$files["files"][] = $this->fileinfo($wert,$mime);
					}
					if($this->output['resource']['showResourceN3']) {
						$files["files"][] = $this->fileinfo($wert.".n3","N3File");
					}
					if($this->output['resource']['showResourceRDF']) {
						$files["files"][] = $this->fileinfo($wert.".rdf","RDFFile");
					}				    		
	  			}	
				else {
					$files["files"][] = $this->fileinfo($wert,$mime);		    		
	  			}			
			}		
		}	
	}
}  
?>

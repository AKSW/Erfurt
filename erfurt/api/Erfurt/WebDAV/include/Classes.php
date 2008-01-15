<?php
/**
*list all classes as directories of given modell limit 50 in this pattern C_0_50
*the Intention of this first Alogrithum is to separat the results of quering modell to 50, because response time could be to slowly
*This Matching will show the classes as an directory and the Instances will be shown as file which are configured in the config.inc.php 
*either .n3 or .rdf or both together
*/
$this->GetComponents($path);
if($this->components[3] == NULL){
		//ALLE restlich vorhandenen Klassen anzeigen
		
		if($this->show_system_class){
			$o_querys=$this->querystring."SELECT DISTINCT ?x
			WHERE {?x rdf:type owl:Class .
				      }
			ORDER BY ?x";
												
			$r_querys=$this->querystring3."SELECT DISTINCT ?y
					WHERE {
							?y rdf:type rdfs:Class .
					            }
						    ORDER BY ?y";
			$o_res = $this->Erfurt_selectedModel->sparqlQuery($o_querys);
			$r_res = $this->Erfurt_selectedModel->sparqlQuery($r_querys);
			if(is_array($r_res) && !is_array($o_res)){
				foreach($r_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?y']->getLabel(),$path)) unset($r_res[$O_Array]);
				}
				$result = $r_res;								
			}
			else if(!is_array($r_res) && is_array($o_res)){
				foreach($o_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?x']->getLabel(),$path)) unset($o_res[$O_Array]);
				}
				$result = $o_res;								
			}
			else if(is_array($r_res) && is_array($o_res)){
				foreach($r_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?y']->getLabel(),$path)) unset($r_res[$O_Array]);
				}
				foreach($o_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?x']->getLabel(),$path)) unset($o_res[$O_Array]);
				}
				$result = array_merge($o_res,$r_res);
			}	
		}
		else {
			
			$query=$this->querystring."SELECT DISTINCT ?classes
			WHERE {?y rdf:type ?classes .
					      }
			ORDER BY ?classes";											
			$result = $this->Erfurt_selectedModel->sparqlQuery($query);						
		}
		//trimmen des Ergebnisses mämlich nur Basisklassen darzustellen
               //FindSuperClass(

		for($i=0;$i < count($result);$i = $i+$this->limit){
			$anfang = $i;
			$ende = $i+$this->limit;
			$pfad=$path."C_".$anfang."_".$ende."/";
			$this->Ausgabe_formal("Pfad",$pfad,$files,"Resource");
		}
}
/**
*if an directory C_0_50 is given then we use the numbers to create offset 
*/
else if($this->components[3] != NULL && $this->components[4] == NULL) {
	list($bla,$anfang,$bli) = split("_",$this->components[3]);
	if($this->show_system_class){
	
		$o_query= $this->querystring." SELECT DISTINCT ?x
		WHERE {?x rdf:type owl:Class
			}
			ORDER BY ?x";	
		$r_query= $this->querystring." SELECT DISTINCT ?r
		WHERE {?r rdf:type rdfs:Class
			}
			ORDER BY ?r";	
			$o_res = $this -> Erfurt_selectedModel ->sparqlQuery($o_query);
			$r_res = $this -> Erfurt_selectedModel ->sparqlQuery($r_query);
			if(is_array($r_res) && !is_array($o_res)){
				foreach($r_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?r']->getLabel(),$path)) unset($r_res[$O_Array]);
				}
				$result = $r_res;								
			}
			else if(!is_array($r_res) && is_array($o_res)){
				 foreach($o_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?x']->getLabel(),$path)) unset($o_res[$O_Array]);
				}
				$result = $o_res;								
			}
			else if(is_array($r_res) && is_array($o_res)){
				foreach($o_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?x']->getLabel(),$path)) unset($o_res[$O_Array]);
				}
				foreach($r_res as $O_Array => $O_Value){
					if(!$this->FindSuperClass($O_Value['?r']->getLabel(),$path)) unset($r_res[$O_Array]);
				}
				$result = array_merge($o_res,$r_res);
			}
		$sub_result = array_slice($result,$anfang,$this->limit);
	}
	
	else {
		$query=$this->querystring."SELECT DISTINCT ?class
		WHERE {
			?x rdf:type ?class	
			}
			ORDER BY ?class";
			$res = $this -> Erfurt_selectedModel ->sparqlQuery($query);
			$sub_result = array_slice($res,$anfang,$this->limit);
	}
}	
/**
*All the Rest
*/
else {
	$class = $this->displayname2iri(basename($path));
	$inst_query.=$this->querystring."SELECT DISTINCT ?y 
	WHERE { 
		?y rdf:type <$class>
	}";		
	//weitere Unterklassen
	$sub_query.=$this->querystring."SELECT DISTINCT ?x 
	WHERE { 
		?x rdfs:subClassOf <$class>
	}";		
	$inst_result = $this -> Erfurt_selectedModel ->sparqlQuery($inst_query);		
	$sub_result = $this -> Erfurt_selectedModel ->sparqlQuery($sub_query);	
}
/**
*Output of all found classes
*/	
if($sub_result==NULL && $inst_result==NULL) $files["files"][] = $this->fileinfo("keine weiteren Objekte ","Literal"); 
else if(is_array($sub_result)){
	foreach($sub_result as $O_Array => $O_Value){
   		foreach($O_Value as $Ob =>$o_wert){
   			$wert_neu = $o_wert->getLabel();
			$wert=$this->iri2displayname($wert_neu);
   			if(is_a($o_wert,"BlankNode")) {
				$wert =$path."_:".$wert; 
			}
			else {
   	   			$wert = $path.$wert;	
			}

   			if($this->output['class']['showClassDir']) {
					$files["files"][] = $this->fileinfo($wert,"Resource");						
			}
			//only an Instance exists then show the *.csv file
			if($this->output['class']['showCSV'] &&$this->components[3] =="") {
				//find out instances of $wert
				$exist_Instance=false;
				$query_neu = $this->querystring."SELECT DISTINCT ?x
				WHERE { ?x rdf:type <$wert_neu>
								}
				LIMIT 1";
				$res_neu = $this -> Erfurt_selectedModel ->sparqlquery($query_neu);
					//instance exist	
				if(!empty($res_neu) && is_array($res_neu)){
						$exist_Instance = true;	
				}
				if(($exist_Instance==true) && $this->FindSuperClass($wert_neu,$path)) {
					$files["files"][] = $this->fileinfo($wert.".csv","CSVFile");								
				}	
    		}
       }
	}
}
if(is_array($inst_result)) {
	foreach($inst_result as $O_Array => $O_Value){
   	foreach($O_Value as $Ob =>$o_wert){
   		$wert_neu = $o_wert->getLabel();
			$wert =$this->iri2displayname($wert_neu);
			$wert =$path.$wert;
			if($this->output['resource']['showResourceN3']) {
				$files["files"][] = $this->fileinfo($wert.".n3","N3File");
			}
			if($this->output['resource']['showResourceRDF']) {
				$files["files"][] = $this->fileinfo($wert.".rdf","RDFFile");
			}				    		
		}
	}		
}	
?>
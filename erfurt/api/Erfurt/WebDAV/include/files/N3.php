<?php
/**
  *N3- Output
  *@param string filename
  *@return
  *@version $Id$
*/		     
//Umwandeln des .n3 files zu normalen Subjekt
	$sub_array = explode(".n3",$candidate);
	if(count($sub_array) ==3) $sub= $sub_array[0].".n3";
	else $sub = $sub_array[0];
	$subname =rtrim($this->displayname2iri($sub));	
	$subj = new Resource($subname);			
	$querystring= "SELECT ?y ?z \n
		WHERE 	{ 
		<$subname> ?y ?z
		}";            	
  	$result = $this->Model->sparqlQuery($querystring);
	$neu_model = ModelFactory::getDefaultModel();	
	if(!empty($result) && is_array($result)){
		foreach($result as $O_Array => $O_Value){
			//parse the predicate
			$pred = new Resource($O_Value['?y']->getLabel());
			//parse the object				
			if(is_a($O_Value['?z'],"BlankNode")){
				$obj = new BlankNode($O_Value['?z']->getLabel());
			}
			else if(is_a($O_Value['?z'],"Resource")){
				$obj = new Resource($O_Value['?z']->getLabel());
			}
			else if(is_a($O_Value['?z'],"Literal")){
				$obj =new Literal($O_Value['?z']->getLabel())	;	
			}
			//Prevend to include the statement		
			$statement = new Statement($subj,$pred,$obj);
			//add to the model					
			$neu_model->add($statement);
		}
	}
//N3-Serializer, der das ganze Modell anschlieп·б╘Б∙╚nd serialisiert					
	$ser = new N3Serializer();
	$n3 =&$ser->serialize($neu_model);
//Ausgabe dient als Rckgabewert des GET-Aufrufes
	echo $n3;				
?>